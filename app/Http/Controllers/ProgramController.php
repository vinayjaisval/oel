<?php

namespace App\Http\Controllers;

use App\Models\{
    Country,
    Currency,
    Documents,
    EducationLevel,
    EngProficiencyLevel,
    Exam,
    Fieldsofstudytype,
    GradingScheme,
    HomeProgramLevel,
    Program,
    ProgramDiscipline,
    ProgramLevel,
    ProgramSubdiscipline,
    ProgramSubLevel,
    SchoolAttended,
    Student,
    Subject,
    University,
    StudentByAgent,
    Agent,
    user,
    ProgramEnglishRequired
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\PaymentsLink;
use Illuminate\Support\Facades\DB;
use Carbon\carbon;

class ProgramController extends Controller
{
    public function manage_program(Request $request)
{
    // FIX: remove default dropdown values
    $approve_status = ($request->approve_status == "-Select Approval-") ? null : $request->approve_status;
    $user_id        = ($request->user_id == "-Select User-") ? null : $request->user_id;

    $program = Program::query()
        ->select([
            'id', 'name', 'school_id', 'program_level_id', 'length', 'intake', 'year',
            'is_approved', 'scholarship_available', 'scholarship_amount', 'scholarship_currency',
            'user_id', 'updated_at', 'created_at',
        ])
        ->with([
            'programLevel:id,name',
            'school:id,university_name',
        ])

        // University name search
        ->when($request->univerisity_name, function ($query, $universityName) {
            $query->whereHas('school', function ($q) use ($universityName) {
                $q->where('university_name', 'LIKE', "%{$universityName}%");
            });
        })

        // Program name search
        ->when($request->program_name, function ($query, $programName) {
            if (strlen($programName) === 1) {
                $query->where('name', 'LIKE', "{$programName}%");
            } else {
                $query->where('name', 'LIKE', "%{$programName}%");
            }
        })

        // Date filtering
        ->when($request->from_date && $request->to_date, function ($query) use ($request) {
            $query->whereBetween('updated_at', [$request->from_date, $request->to_date]);
        })
        ->when($request->from_date && !$request->to_date, function ($query) use ($request) {
            $query->whereDate('updated_at', '>=', $request->from_date);
        })
        ->when(!$request->from_date && $request->to_date, function ($query) use ($request) {
            $query->whereDate('updated_at', '<=', $request->to_date);
        })

        // 🎯 USER filter FIXED
        ->when($user_id, function ($query, $userId) {
            $query->where('user_id', $userId);
        })

        // 🎯 APPROVAL filter FIXED
        ->when($approve_status, function ($query, $status) {
            if ($status === 'approve') {
                $query->where('is_approved', 1);
            } elseif ($status === 'unapprove') {
                $query->where('is_approved', 0);
            } elseif ($status === 'unapprove_including_null') {
                $query->where(function ($q) { $q->whereNull('is_approved')->orWhere('is_approved', 0); });
            }
        })

        ->latest();

    $program = $program->paginate(20)->appends($request->all());

    $eng_proficiency_level = EngProficiencyLevel::all();

    $users = User::whereIn('admin_type', ['Sub Data-Operator', 'Data oprator', 'Digital Marketing'])
        ->where('is_approve', 1)
        ->get(['id', 'name']);

    $stats = Cache::remember('manage_program_stats', 300, function () {
        return [
            'total' => Program::count(),
            'approved' => Program::where('is_approved', 1)->count(),
            'pending' => Program::where('is_approved', 0)->count(),
            'with_scholarship' => Program::where('scholarship_available', 1)->count(),
        ];
    });

    return view('admin.program.manage-program', compact('program', 'users', 'eng_proficiency_level', 'stats'));
}

    public static function forgetProgramStatsCache()
    {
        Cache::forget('manage_program_stats');
    }

    public function searchUniversities(Request $request)
    {
        $search = trim((string) $request->get('q'));

        $universities = University::query()
            ->where('is_approved', 1)
            ->when($search !== '', function ($query) use ($search) {
                $query->where('university_name', 'LIKE', "%{$search}%");
            })
            ->orderBy('university_name')
            ->limit(20)
            ->get(['id', 'university_name']);

        return response()->json([
            'results' => $universities->map(function ($u) {
                return ['id' => $u->id, 'text' => $u->university_name];
            }),
        ]);
    }
    
    

    public function approve_program(Request $request)
    {
        $program = Program::with('study_type', 'educationLevel', 'currency_data', 'ProgramCategory', 'school')->where('is_approved', 1)
            ->whereHas('school', function ($query) use ($request) {
                if ($request->univerisity_name) {
                    $query->where('university_name', 'LIKE', "%{$request->univerisity_name}%");
                }
            });
        $user = Auth::user();
        if (!($user->hasRole('Administrator'))) {
            //$program->where('user_id',$user->id);
        }
        if ($request->program_name) {
            $program->where('name', 'LIKE', "%{$request->program_name}%");
        }
        $program = $program->paginate(12);
        return view('admin.program.approve', compact('program'));
    }


    public function add_program(Request $request)
    {
        [$program_discipline, $program_level, $currency] = $this->masterLists();

        // Only needed so the university field can show the previously
        // selected value after a validation error (search is AJAX now).
        $selected_university = old('school_id')
            ? University::where('id', old('school_id'))->first(['id', 'university_name'])
            : null;

        return view('admin.program.create-program', compact('program_discipline', 'program_level', 'currency', 'selected_university'));
    }

    protected function masterLists()
    {
        $program_discipline = Cache::remember('master_program_discipline', 600, function () {
            return ProgramDiscipline::select('name', 'id')->where('status', '1')->get();
        });

        $program_level = Cache::remember('master_program_level', 600, function () {
            return ProgramLevel::get();
        });

        $currency = Cache::remember('master_currency', 600, function () {
            return Currency::get();
        });

        return [$program_discipline, $program_level, $currency];
    }


    public function store_program(Request $request)
    {
        $request->validate([
            'school_id' => 'required|max:200',
            'name' => 'required|max:1000',
            'length' => 'required|max:200',
            'programType' => 'required|max:200',
            'programCampus' => 'required|max:200',
            'lang_spec_for_program' => 'required|max:200',
            'application_fee' => 'required|max:200',
            'application_apply_date' => 'required|max:200',
            //'application_closing_date' => 'required|max:200',
            'tution_fee' => 'required|max:200',
            'currency' => 'required|max:200',
            'intake' => 'required|max:200',
            'year' => 'required|max:200',
            'program_discipline' => 'required',
            'work_experience' => 'required|max:200',
            'scholarship_available' => 'nullable|in:0,1',
            'scholarship_amount' => 'required_if:scholarship_available,1|nullable|numeric|min:0',
            'scholarship_currency' => 'required_if:scholarship_available,1|nullable|max:10',
        ]);
        // $sub_type = gettype($request->subject_id_input);
        // if($sub_type == "string"){
        //     $subject_id_input = $request->subject_id_input;
        // } else {
        //     if(isset($request->subject_id_input)){
        //         $subject_id_input = implode(",",$request->subject_id_input);
        //     } else {
        //         $subject_id_input = "";
        //     }
        // }
        $programSave = DB::table('program')
            ->insert([
                'user_id' => Auth::user()->id,
                'school_id' => $request->school_id ?? null,
                'name' => $request->name  ?? null,
                'length' => $request->length  ?? null,
                'programType' => $request->programType  ?? null,
                'programCampus' => $request->programCampus  ?? null,
                'grading_number' => $request->grading_number  ?? null,
                'description' => $request->details  ?? null,
                'grading_scheme_id' => $request->grading_scheme_id  ?? null,
                'application_fee' => $request->application_fee  ?? null,
                'application_apply_date' => $request->application_apply_date  ?? null,
                'application_closing_date' => $request->application_closing_date  ?? null,
                'lang_spec_for_program' => $request->lang_spec_for_program  ?? null,
                'program_level_id' => $request->program_level  ?? null,
                'program_sub_level' => $request->program_sub_level  ?? null,
                'education_level_id' => $request->education_level  ?? null,
                'program_discipline' => $request->program_discipline ?? null,
                'program_subdiscipline' => $request->program_subdiscipline ?? null,
                'tution_fee' => $request->tution_fee  ?? null,
                'currency' => $request->currency  ?? null,
                'intake' => $request->intake  ?? null,
                'year' => $request->year  ?? null,
                'min_gpa' => $request->min_gpa  ?? null,
                'other_exam' => $request->other_exam,
                'other_requirements' => $request->other_requirements  ?? null,
                'extra_notes' => $request->extra_notes  ?? null,
                'work_experience' => $request->work_experience ?? null,
                // 'tags' => $request->tags ?? null,
                'priority' => $request->priority ?? null,
                'cost_of_living_fee' => '00.00',
                'cost_of_living' => '00.00',
                'is_approved' => '1',
                'scholarship_available' => $request->scholarship_available == 1 ? 1 : 0,
                'scholarship_name' => $request->scholarship_available == 1 ? ($request->scholarship_name ?? null) : null,
                'scholarship_amount' => $request->scholarship_available == 1 ? $request->scholarship_amount : null,
                'scholarship_currency' => $request->scholarship_available == 1 ? $request->scholarship_currency : null,
            ]);
        self::forgetProgramStatsCache();
        return redirect()->route('manage-program')->with('success', 'Program Added Successfully');
    }

    public function edit_program($id)
    {
        $program = Program::with('currency_data')->find($id);

        $selected_university = University::where('id', $program->school_id)->first(['id', 'university_name']);

        $program_discipline = ProgramDiscipline::select('name', 'id')->where('status', '1')->get();
        $program_subdiscipline = ProgramSubdiscipline::select('name', 'id')->where('id', $program->program_subdiscipline)->where('status', '1')->get();

        $grading_scheme = GradingScheme::select('name', 'id')->where('id', $program->grading_scheme_id)->get();

        [, $program_level, $currency] = $this->masterLists();
        $program_sublevel = ProgramSubLevel::where('id', $program->program_sub_level)->get();
        $education_level = EducationLevel::where('id', $program->education_level_id)->get();
        $other_exam = Exam::where('id', $program->other_exam)->get();
        return view('admin.program.edit-program', compact('grading_scheme', 'other_exam', 'program_sublevel', 'program_level', 'program_discipline', 'program_subdiscipline', 'selected_university', 'education_level', 'currency', 'program'));
    }

    public function view_program($id)
    {
        $program = Program::with('study_type', 'programLevel', 'educationLevel', 'currency_data', 'ProgramCategory', 'school')->where('is_approved', 1)->find($id);
        return view('admin.program.program-details', compact('program'));
    }


    public function update_program(Request $request, $id)
    {
        $request->validate([
            'school_id' => 'required|max:200',
            'name' => 'required|max:1000',
            'length' => 'required|max:200',
            'programType' => 'required|max:200',
            'programCampus' => 'required|max:200',
            'lang_spec_for_program' => 'required|max:200',
            'program_level' => 'required|max:200',
            'application_fee' => 'required|max:200',
            'application_apply_date' => 'required|max:200',
            //'application_closing_date' => 'required|max:200',
            'tution_fee' => 'required|max:200',
            'currency' => 'required|max:200',
            'intake' => 'required|max:200',
            'year' => 'required|max:200',
            'program_discipline' => 'required|max:200',
            'work_experience' => 'required|max:200',
            'scholarship_available' => 'nullable|in:0,1',
            'scholarship_amount' => 'required_if:scholarship_available,1|nullable|numeric|min:0',
            'scholarship_currency' => 'required_if:scholarship_available,1|nullable|max:10',
        ]);

        $programSave = Program::find($id);
        Cache::forget("program_details_{$id}");
        $programSave->update([
            // 'user_id' => Auth::user()->id,
            'school_id' => $request->school_id,
            'name' => $request->name,
            'length' => $request->length,
            'programType' => $request->programType,
            'programCampus' => $request->programCampus,
            'grading_number' => $request->grading_number,
            'fieldsofstudytype' => $request->fieldsofstudytype,
            'description' => $request->details,
            'program_level_id' => $request->program_level,
            'program_sub_level' => $request->program_sub_level  ?? null,
            'education_level_id' => $request->education_level,
            'grading_scheme_id' => $request->grading_scheme_id,
            'application_fee' => $request->application_fee,
            'other_exam' => $request->other_exam,
            'application_apply_date' => $request->application_apply_date,
            'application_closing_date' => $request->application_closing_date,
            'program_discipline' => $request->program_discipline,
            'program_subdiscipline' => $request->program_subdiscipline,
            'tution_fee' => $request->tution_fee,
            'currency' => $request->currency,
            'intake' => $request->intake,
            'year' => $request->year,
            'min_gpa' => $request->min_gpa,
            'other_requirements' => $request->other_requirements,
            'extra_notes' => $request->extra_notes,
            'work_experience' => $request->work_experience ?? null,
            // 'tags' => $request->tags,
            'priority' => $request->priority,
            'cost_of_living_fee' => '00.00',
            'cost_of_living' => '00.00',
            // 'is_approved' => 0,
            'scholarship_available' => $request->scholarship_available == 1 ? 1 : 0,
            'scholarship_name' => $request->scholarship_available == 1 ? ($request->scholarship_name ?? null) : null,
            'scholarship_amount' => $request->scholarship_available == 1 ? $request->scholarship_amount : null,
            'scholarship_currency' => $request->scholarship_available == 1 ? $request->scholarship_currency : null,
        ]);
        self::forgetProgramStatsCache();
        return redirect()->route('manage-program')->with('success', 'Program Updated Successfully');
    }


    public function req_score_prog_add(Request $request)
    {
        if ($request->type != 9) {
            $request->validate([
                'type' => 'required',
                'program_id' => 'required',
                'listening_score' => 'required|numeric',
                'writing_score' => 'required|numeric',
                'reading_score' => 'required|numeric',
                'speaking_score' => 'required|numeric',
                'overall_score' => 'required|numeric',
            ]);
        } else {
            $request->validate([
                'type' => 'required',
                'program_id' => 'required',
                'remarks' => 'required',
            ]);
        }

        $reqScore = DB::table('program_english_required')
            ->updateOrInsert(
                ['program_id' => $request->program_id, 'type' => $request->type],
                [
                    'type' => $request->type,
                    'listening_score' => $request->listening_score,
                    'writing_score' => $request->writing_score,
                    'reading_score' => $request->reading_score,
                    'speaking_score' => $request->speaking_score,
                    'overall_score' => $request->overall_score,
                    'remarks' => $request->remarks,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            );
        Cache::forget("program_details_{$request->program_id}");
        return response()->json(['status' => true, 'success' => 'Data Inserted Successfully', 'program_id' => $request->program_id]);
    }

    public function fetch_req_score_prog(Request $request)
    {
        $data = DB::table('program_english_required')->leftJoin('eng_proficiency_levels', 'eng_proficiency_levels.id', '=', 'program_english_required.type')->where('program_id', $request->program_id)->select('program_english_required.*', 'eng_proficiency_levels.name')->get();
        // $eng_proficiency_level = EngProficiencyLevel::paginate(12);
        // dd($data);

        return response()->json([
            'status' => true,
            'data' => $data,
            'program_id' => $request->program_id
        ]);
    }






    public function updateScoreProgram(Request $request)
    {
        $score = DB::table('program_english_required')->where('id', $request->score_id)->first();
        $program_id = $score->program_id;
        if ($score) {
            $deleteScore = DB::table('program_english_required')->where('id', $request->score_id)->delete();
            Cache::forget("program_details_{$program_id}");
            return response()->json(['status' => true, 'success' => 'Data Deleted Successfully', 'program_id' => $program_id]);
        } else {
            return response()->json(['status' => false, 'success' => 'Data Not Exist', 'program_id', $score->program_id]);
        }
    }

    public function update_program_commission(Request $request)
    {
        Cache::forget("program_details_{$request->program_commission_id}");
        DB::table('program')
            ->Where('id', $request->program_commission_id)
            ->update([
                'commission' => $request->commission,
                'commission_for_program_payment_to_franchise' => $request->commission_for_program_payment_to_franchise,
                'commission_for_added_program_payment_to_franchise' => $request->commission_for_added_program_payment_to_franchise,
                'commission_for_program_payment_to_counselor' => $request->commission_for_program_payment_to_counselor
            ]);
        return response()->json(['message' => 'Program Commission Update Successfully', 'status' => true]);
    }

    public function get_program_commission(Request $request)
    {
        $program_commission = DB::table('program')
            ->select('commission', 'commission_for_program_payment_to_franchise', 'commission_for_added_program_payment_to_franchise', 'commission_for_program_payment_to_counselor')
            ->where('id', $request->program_id)
            ->first();
        return response()->json(['data' => $program_commission]);
    }
    public function program_level_details(Request $request)
    {
        $home_program = HomeProgramLevel::with('home_program_levels')->where('status', 1);
        if ($request->program_level) {
            $home_program->where('program_level_id', $request->program_level);
        }
        $home_program = $home_program->paginate(12);
        $program_level = ProgramLevel::get();
        return view('admin.program.home-program-level', compact('home_program', 'program_level'));
    }

    public function create_program_details()
    {
        $program_level = ProgramLevel::get();
        return view('admin.program.add-home-program-details', compact('program_level'));
    }

    public function store_program_details(Request $request)
    {
        $request->validate([
            'program_level_id' => 'required',
            'description' => 'required',
        ]);

        HomeProgramLevel::create($request->except('_token'));
        return redirect()->route('program-level-details')->with('success', 'Data Inserted Successfully');
    }

    public function edit_program_details($id)
    {
        $program_level = ProgramLevel::get();
        $home_program = HomeProgramLevel::find($id);
        return view('admin.program.edit-home-program-details', compact('program_level', 'home_program'));
    }

    public function update_program_details(Request $request, $id)
    {
        $request->validate([
            'program_level_id' => 'required',
            'description' => 'required',
        ]);
        $programLevel = HomeProgramLevel::find($id);
        $programLevel->update([
            'program_level_id' => $request->program_level_id,
            'description' => $request->description,
        ]);
        return redirect()->route('program-level-details')->with('success', 'Data Updated Successfully');
    }

    public function delete_program_details($id)
    {
        $delete_program = HomeProgramLevel::find($id);
        if ($delete_program) {
            $delete_program->delete();
            return redirect()->route('program-level-details')->with('success', 'Data Deleted Successfully');
        }
        return redirect()->route('program-level-details')->with('error', 'Data not found');
    }


    // program sublevel
  public function program_sub_level(Request $request)
{
    $query = ProgramSubLevel::with('programLevel');

    // ✅ Name filter (sub level + level relation)
    if ($request->name) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->name . '%')
              ->orWhereHas('programLevel', function ($qq) use ($request) {
                  $qq->where('name', 'like', '%' . $request->name . '%');
              });
        });
    }

    // ✅ Pagination + filter preserve
    $program_sub_level = $query->paginate(12)->withQueryString();

    return view('admin.program.programsublevel.index', compact('program_sub_level'));
}

    public function program_sub_level_create()
    {
        $program_level = ProgramLevel::paginate(12);
        return view('admin.program.programsublevel.create', compact('program_level'));
    }

    public function program_sub_level_store(Request $request)
    {
        $request->validate([
            'program_id' => 'required',
            'name' => 'required',
        ]);

        ProgramSubLevel::create($request->except('_token'));
        return redirect()->route('program-sub-level')->with('success', 'Data Inserted Successfully');
    }

    public function program_sub_level_edit($id)
    {
        $program_sub_level = ProgramSubLevel::find($id);
        $programlevels = ProgramLevel::paginate(12);
        return view('admin.program.programsublevel.edit', compact('program_sub_level', 'programlevels'));
    }

    public function program_sub_level_update(Request $request, $id)
    {
        $request->validate([
            'program_id' => 'required',
            'name' => 'required',
        ]);

        $programsubdiscipline = ProgramSubLevel::find($id);
        $programsubdiscipline->update($request->except('_token'));
        return redirect()->route('program-sub-level')->with('success', 'Data Updated Successfully');
    }

    public function delete_program_sub_level($id)
    {
        $programsubdiscipline = ProgramSubLevel::find($id);
        if ($programsubdiscipline) {
            $programsubdiscipline->delete();
            return redirect()->route('program-sub-level')->with('success', 'Data Deleted Successfully');
        }
        return redirect()->route('program-sub-level')->with('error', 'Data not found');
    }



    // educationlevel

    public function education_level(Request $request)
    {
        $name = $request->get('name');
        $educationlevel = EducationLevel::with('programLevel', 'program_sublevel')->when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->paginate(12);

        return view('admin.program.educationlevel.index', compact('educationlevel'));
    }

    public function education_level_create()
    {
        $programlevels = ProgramLevel::select('name', 'id')->get();
        return view('admin.program.educationlevel.create', compact('programlevels'));
    }

    public function education_level_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'program_level_id' => 'required',
        ]);
        EducationLevel::create($request->except('_token'));
        return redirect()->route('education-level')->with('success', 'Data Inserted Successfully');
    }

    public function education_level_edit($id)
    {
        $educationlevel = EducationLevel::find($id);
        $programlevels = ProgramLevel::select('name', 'id')->get();
        $program_sublevels = ProgramSubLevel::get();
        return view('admin.program.educationlevel.edit', compact('educationlevel', 'programlevels', 'program_sublevels'));
    }

    public function education_level_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'program_level_id' => 'required',
        ]);
        $educationlevel = EducationLevel::find($id);
        $educationlevel->update([
            'name' => $request->name,
            'program_level_id' => $request->program_level_id,
            'program_sublevel_id' => $request->program_sublevel_id,
        ]);
        return redirect()->route('education-level')->with('success', 'Data Updated Successfully');
    }

    public function education_level_delete($id)
    {
        if (EducationLevel::find($id)) {
            EducationLevel::find($id)->delete();
            return redirect()->route('education-level')->with('success', 'Data Deleted Successfully');
        } else {
            return redirect()->route('education-level')->with('error', 'Data not found');
        }
    }
    // educationlevel

    public function program_level(Request $request)
    {
        $name = $request->get('name');
        $programlevel = ProgramLevel::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->paginate(12);

        return view('admin.program.programlevel.index', compact('programlevel'));
    }

    public function program_level_create()
    {
        return view('admin.program.programlevel.create');
    }

    public function program_level_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        ProgramLevel::create($request->except('_token'));
        return redirect()->route('program-level')->with('success', 'Data Inserted Successfully');
    }

    public function program_level_edit($id)
    {
        $programlevel = ProgramLevel::find($id);
        return view('admin.program.programlevel.edit', compact('programlevel'));
    }

    public function program_level_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $programlevel = programLevel::find($id);
        $programlevel->update([
            'name' => $request->name,
            'orders' => $request->orders
        ]);
        return redirect()->route('program-level')->with('success', 'Data Updated Successfully');
    }

    public function program_level_delete($id)
    {
        if (ProgramLevel::find($id)) {
            ProgramLevel::find($id)->delete();
            return redirect()->route('program-level')->with('success', 'Data Deleted Successfully');
        } else {
            return redirect()->route('program-level')->with('error', 'Data not found');
        }
    }

    // grading scheme
    public function grading_scheme(Request $request)
    {
        $name = $request->get('name');
        $country_id = $request->get('country_id');
        $education_level_id = $request->get('education_level_id');

        $grading_scheme = GradingScheme::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->when($country_id, function ($query) use ($country_id) {
            return $query->where('country_id', $country_id);
        })->when($education_level_id, function ($query) use ($education_level_id) {
            return $query->where('education_level_id', $education_level_id);
        })->with('country', 'education_level')->paginate(12);

        $country = Country::get();
        $education_level = EducationLevel::get();
        return view('admin.program.gradingscheme.index', compact('grading_scheme', 'country', 'education_level'));
    }

    public function grading_scheme_create()
    {
        $country = Country::get();
        $education_level = EducationLevel::get();
        return view('admin.program.gradingscheme.create', compact('country', 'education_level'));
    }

    public function grading_scheme_store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200',
            'country_id' => 'required|numeric',
            'education_level_id' => 'required|numeric'
        ]);
        GradingScheme::create($request->except('_token'));
        return redirect()->route('grading-scheme')->with('success', 'Data Inserted Successfully');
    }

    public function grading_scheme_edit($id)
    {
        $gradingScheme = GradingScheme::find($id);
        $country = Country::get();
        $education_level = EducationLevel::get();
        return view('admin.program.gradingscheme.edit', compact('gradingScheme', 'country', 'education_level'));
    }


    public function grading_scheme_delete($id)
    {
        if (GradingScheme::find($id)) {
            GradingScheme::find($id)->delete();
            return redirect()->route('grading-scheme')->with('success', 'Data Deleted Successfully');
        } else {
            return redirect()->route('grading-scheme')->with('error', 'Data not found');
        }
    }

    public function grading_scheme_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:200',
            'country_id' => 'required|numeric',
            'education_level_id' => 'required|numeric'
        ]);
        $grading_scheme = GradingScheme::find($id);
        $grading_scheme->update([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'education_level_id' => $request->education_level_id,
        ]);
        return redirect()->route('grading-scheme')->with('success', 'Data Updated Successfully');
    }
    // exam


    public function exam(Request $request)
    {
        $name = $request->get('name');
        $exam = Exam::with('program_level')->when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->paginate(12);

        return view('admin.program.exam.index', compact('exam'));
    }

    public function exam_create()
    {
        $programlevels = ProgramLevel::select('name', 'id')->get();
        return view('admin.program.exam.create', compact('programlevels'));
    }

    public function exam_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'program_level_id' => 'required',
            'number' => 'required|max:11'
        ]);
        Exam::create($request->except('_token'));
        return redirect()->route('exam')->with('success', 'Data Inserted Successfully');
    }

    public function exam_edit($id)
    {
        $exam = Exam::find($id);
        $programlevels = ProgramLevel::select('name', 'id')->get();
        return view('admin.program.exam.edit', compact('exam', 'programlevels'));
    }

    public function exam_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'program_level_id' => 'required',
            'number' => 'required|max:11'
        ]);
        $exam = Exam::find($id);
        $exam->update([
            'name' => $request->name,
            'program_level_id' => $request->program_level_id,
            'number' => $request->number
        ]);
        return redirect()->route('exam')->with('success', 'Data Updated Successfully');
    }


    public function exam_delete($id)
    {
        $exam = Exam::find($id);
        if ($exam) {
            $exam->delete();
            return redirect()->route('exam')->with('success', 'Data Deleted Successfully');
        } else {
            return redirect()->route('exam')->with('error', 'Data Not Found');
        }
    }


    // field of study

    public function field_of_study(Request $request)
    {
        $name = $request->get('name');
        $status = $request->get('status');
        $fieldofstudy = Fieldsofstudytype::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->when($status !== null, function ($query) use ($status) {
            return $query->where('status', $status);
        })->paginate(12);

        return view('admin.program.fieldofstudy.index', compact('fieldofstudy'))->with('status', $status)->with('name', $name);
    }

    public function field_of_study_create()
    {
        return view('admin.program.fieldofstudy.create');
    }

    public function field_of_study_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);
        Fieldsofstudytype::create($request->except('_token'));
        return redirect()->route('field-of-study')->with('success', 'Data Inserted Successfully');
    }

    public function field_of_study_edit($id)
    {
        $fieldOfStudy = Fieldsofstudytype::find($id);
        return view('admin.program.fieldofstudy.edit', compact('fieldOfStudy'));
    }

    public function field_of_study_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);
        $fieldofstudy = Fieldsofstudytype::find($id);
        $fieldofstudy->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
        return redirect()->route('field-of-study')->with('success', 'Data Updated Successfully');
    }
    public function field_of_study_delete($id)
    {
        $fieldofstudy = Fieldsofstudytype::find($id);
        if ($fieldofstudy) {
            $fieldofstudy->delete();
            return redirect()->route('field-of-study')->with('success', 'Data Deleted Successfully');
        }
        return redirect()->route('field-of-study')->with('error', 'Data Not Found');
    }
    // subjects

    public function subjects(Request $request)
    {
        $name = $request->get('name');
        $status = $request->get('status');
        $subjects = Subject::when($name, function ($query) use ($name) {
            return $query->where('subject_name', 'like', '%' . $name . '%');
        })->when($status !== null, function ($query) use ($status) {
            return $query->where('status', $status);
        })->paginate(12);
        return view('admin.program.subjects.index', compact('subjects'))->with('status', $status)->with('name', $name);
    }

    public function subjects_create()
    {
        return view('admin.program.subjects.create');
    }

    public function subjects_store(Request $request)
    {
        $request->validate([
            'subject_name' => 'required',
            'status' => 'required'
        ]);
        Subject::create($request->except('_token'));
        return redirect()->route('subject')->with('success', 'Data Inserted Successfully');
    }

    public function subjects_edit($id)
    {
        $subject = Subject::find($id);
        return view('admin.program.subjects.edit', compact('subject'));
    }

    public function subjects_update(Request $request, $id)
    {
        $request->validate([
            'subject_name' => 'required',
            'status' => 'required'
        ]);
        $subject = Subject::find($id);
        $subject->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
        return redirect()->route('subject')->with('success', 'Data Updated Successfully');
    }
    public function subjects_delete($id)
    {
        $subject = Subject::find($id);
        if ($subject) {
            $subject->delete();
            return redirect()->route('subject')->with('success', 'Data Deleted Successfully');
        } else {
            return redirect()->route('subject')->with('success', 'Data not found');
        }
    }


    public function eng_proficiency_level()
    {
        $eng_proficiency_level = EngProficiencyLevel::paginate(12);
        return view('admin.program.eng_proficiency_level.index', compact('eng_proficiency_level'));
    }
    public function eng_proficiency_level_create()
    {
        return view('admin.program.eng_proficiency_level.create');
    }
    public function eng_proficiency_level_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'status' => 'required'
        ]);
        EngProficiencyLevel::create($request->except('_token'));
        return redirect()->route('eng-proficiency-level')->with('success', 'Data Inserted Successfully');
    }
    public function eng_proficiency_level_edit($id)
    {
        $eng_level = EngProficiencyLevel::find($id);
        return view('admin.program.eng_proficiency_level.edit', compact('eng_level'));
    }
    public function eng_proficiency_level_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'number' => 'required',
        ]);
        $eng_level = EngProficiencyLevel::find($id);
        $eng_level->update($request->except('_token'));
        return redirect()->route('eng-proficiency-level')->with('success', 'Data Updated Successfully');
    }
    public function eng_proficiency_level_delete($id)
    {
        $eng_level = EngProficiencyLevel::find($id);
        if ($eng_level) {
            $eng_level->delete();
            return redirect()->route('eng-proficiency-level')->with('success', 'Data Deleted Successfully');
        } else {
            return redirect()->route('eng-proficiency-level')->with('success', 'Data not found');
        }
    }


public function program_discipline(Request $request)
{
    $query = ProgramDiscipline::query();

    // ✅ Name Filter
    if ($request->name) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    // Pagination + query string preserve
    $program_discipline = $query->paginate(12)->withQueryString();

    return view('admin.program.program_discipline.index', compact('program_discipline'));
}
    public function program_discipline_create()
    {
        return view('admin.program.program_discipline.create');
    }
    public function program_discipline_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);
        ProgramDiscipline::create($request->except('_token'));
        return redirect()->route('program-discipline')->with('success', 'Data Inserted Successfully');
    }
    public function program_discipline_edit($id)
    {
        $program_discipline = ProgramDiscipline::find($id);
        return view('admin.program.program_discipline.edit', compact('program_discipline'));
    }
    public function program_discipline_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);
        $program_discipline = ProgramDiscipline::find($id);
        $program_discipline->update($request->except('_token'));
        return redirect()->route('program-discipline')->with('success', 'Data Updated Successfully');
    }
    public function program_discipline_delete($id)
    {
        $program_subdiscipline = ProgramSubdiscipline::where('program_discipline_id', $id)->first();
        if ($program_subdiscipline) {
            return redirect()->route('program-discipline')->with('error', 'Can Not Delete Subdicipline exit not found');
        }
        if (ProgramDiscipline::find($id)) {
            ProgramDiscipline::find($id)->delete();
            return redirect()->route('program-discipline')->with('success', 'Data Deleted Successfully');
        }
        return redirect()->route('program-discipline')->with('error', 'Data not found');
    }


   public function program_subdiscipline(Request $request)
{
    $query = ProgramSubdiscipline::with('programdiscipline');

    // ✅ Name filter (subdiscipline name)
    if ($request->name) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    // ✅ (Optional) Agar tum discipline name se bhi search karna chahte ho
    $query->orWhereHas('programdiscipline', function ($q) use ($request) {
        if ($request->name) {
            $q->where('name', 'like', '%' . $request->name . '%');
        }
    });

    // Pagination + query string preserve
    $program_subdiscipline = $query->paginate(12)->withQueryString();

    return view('admin.program.program_subdiscipline.index', compact('program_subdiscipline'));
}
    public function program_subdiscipline_create()
    {
        $program_discipline = ProgramDiscipline::all();
        return view('admin.program.program_subdiscipline.create', compact('program_discipline'));
    }
    public function program_subdiscipline_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'program_discipline_id' => 'required'
        ]);
        ProgramSubdiscipline::create($request->except('_token'));
        return redirect()->route('program-subdiscipline')->with('success', 'Data Inserted Successfully');
    }
    public function program_subdiscipline_edit($id)
    {
        $program_subdiscipline = ProgramSubdiscipline::find($id);
        $program_discipline = ProgramDiscipline::all();
        return view('admin.program.program_subdiscipline.edit', compact('program_subdiscipline', 'program_discipline'));
    }
    public function program_subdiscipline_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'program_discipline_id' => 'required'
        ]);
        $program_subdiscipline = ProgramSubdiscipline::find($id);
        $program_subdiscipline->update($request->except('_token'));
        return redirect()->route('program-subdiscipline')->with('success', 'Data Updated Successfully');
    }
    public function program_subdiscipline_delete($id)
    {
        $program_subdiscipline = ProgramSubdiscipline::find($id);
        if ($program_subdiscipline) {
            $program_subdiscipline->delete();
            return redirect()->route('program-subdiscipline')->with('success', 'Data Deleted Successfully');
        }
        return redirect()->route('program-subdiscipline')->with('error', 'Data not found');
    }


    public function get_program_sub_discipline(Request $request)
    {
        if ($request->ajax()) {
            $program_subdiscipline = ProgramSubdiscipline::where('status', '1')->where('program_discipline_id', $request->program_discipline_id)->get();
            return response()->json($program_subdiscipline);
        }
    }

    public function get_education_level(Request $request)
    {
        if ($request->ajax()) {
            $programLevelId = is_array($request->program_level_id) ? implode(',', $request->program_level_id) : $request->program_level_id;
            $program_sublevel_id = is_array($request->program_sublevel_id) ? implode(',', $request->program_sublevel_id) : $request->program_sublevel_id;
            $education_level = EducationLevel::where('program_level_id', $programLevelId)->where('program_sublevel_id', $program_sublevel_id)->get();
            return response()->json($education_level);
        }
    }

    public function get_program_sublevel(Request $request)
    {
        if ($request->ajax()) {
            $program_level_id = is_array($request->program_level_id) ? $request->program_level_id : explode(',', $request->program_level_id);
            $program_sub_level = ProgramSubLevel::whereIn('program_id', $program_level_id)->get();
            return response()->json($program_sub_level);
        }
    }

    public function program_subdiscipline_data(Request $request)
    {
        if ($request->ajax()) {
            $disciplineIds = $request->program_displine ?? [];
            $disciplineIds = is_array($disciplineIds) ? $disciplineIds : explode(',', $disciplineIds);
            $disciplineIds = array_filter($disciplineIds, fn ($id) => $id !== null && $id !== '');

            $program_sub_discipline = ProgramSubdiscipline::where('status', 1);

            if (!empty($disciplineIds)) {
                $program_sub_discipline->whereIn('program_discipline_id', $disciplineIds);
            } else {
                $program_sub_discipline->whereRaw('0 = 1');
            }

            return response()->json($program_sub_discipline->get());
        }
    }

    public function education_level_fetch(Request $request)
    {
        $education_level = EducationLevel::where('program_level_id', $request->program_level_id)->where('program_sublevel_id', $request->program_sublevel_id)->get();
        return response()->json($education_level);
    }


    public function fetch_scheme_data(Request $request)
    {
        if ($request->ajax()) {
            $country_id = University::where('id', $request->university_id)->value('country_id');
            $grading_scheme = GradingScheme::where('country_id', $country_id)->where('education_level_id', $request->education_level_id)->get();
            return response()->json($grading_scheme);
        }
    }


    public function other_exam(Request $request)
    {
        if ($request->ajax()) {
            $program_level = is_array($request->program_id) ? $request->program_id : explode(',', $request->program_id);
            $other_exam = Exam::whereIn('program_level_id', $program_level)->get();
            return response()->json($other_exam);
        }
    }


    public function documents()
    {
        $documents = Documents::with('programlevel')->paginate(12);
        return view('admin.program.documents.index', compact('documents'));
    }

    public function documents_edit($id = null)
    {
        $document = Documents::find($id);
        return view('admin.program.documents.edit', compact('document'));
    }

    public function documents_delete($id = null)
    {
        if (Documents::find($id)) {
            Documents::find($id)->delete();
        } else {
            return redirect()->route('documents')->with('error', 'Check id exit or not');
        }
        return redirect()->route('documents')->with('success', 'Data Deleted Successfully');
    }

    public function documents_update(Request $request, $id = null)
    {
        $request->validate([
            'name' => 'required',
            'program_level_id' => 'required',
        ]);
        $document = Documents::find($id)->update([
            'name' => $request->name,
            'program_level_id' => $request->program_level_id,
        ]);
        return redirect()->route('documents')->with('success', 'Data Updated Successfully');
    }

    public function documents_create()
    {
        $programlevels = ProgramLevel::get();
        return view('admin.program.documents.create', compact('programlevels'));
    }

    public function documents_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'program_level_id' => 'required',
        ]);
        Documents::create([
            'name' => $request->name,
            'program_level_id' => $request->program_level_id,
        ]);
        return redirect()->route('documents')->with('success', 'Data Added Successfully');
    }

    // public function total_applied_programm()
    // {
    //     $user=Auth::user();
    //    if($user->hasRole('Administrator')) {
    //         $student = Student::pluck('id');
    //         $students = Student::pluck('user_id');

    //     } else {
    //         $student = Student::where('user_id', $user->id)->pluck('id');
    //         $students = Student::where('added_by', $user->id)->pluck('user_id');

    //     }
    //     if(count($student)<0) {
    //         abort(404);
    //     }
    //     $table_three_sixtee =DB::table('tbl_three_sixtee')->whereIn('sba_id',$student)->select('application','visa_application')->first();
    //     if(isset($table_three_sixtee->application) && $table_three_sixtee->application != 'null' && isset($table_three_sixtee->visa_application) && $table_three_sixtee->visa_application != 'null'){
    //         $application=json_decode($table_three_sixtee->application,true);
    //         $visa_application = $table_three_sixtee->visa_application;
    //         $applied_application = [];
    //         foreach ($application['program_ids'] as $program_id) {
    //             $status_key = $program_id . '_application_status';
    //             $remarks_key = 'remarks_' . $program_id;
    //             if (isset($application[$status_key])) {
    //                 $applied_application[$program_id] = $application[$status_key];
    //             }
    //         }
    //     }else{
    //         $applied_application=[];
    //         $visa_application=null;
    //     }


    //     // $program_applied = PaymentsLink::with('program:name,id,school_id','program.university_name:university_name,id','payments')->orwhere('payment_type_remarks','applied_program_pay_later')->orwhere('payment_type_remarks','applied_program')->whereIn('user_id', $student)->get();
    //     $program_applied = PaymentsLink::with([
    //         'program:id,name,school_id',
    //         'program.university_name:id,university_name',
    //         'payments'
    //     ])
    //     ->when(auth()->user()->role == 'student', function ($query) {
    //         $query->orWhere('payment_type_remarks', 'applied_program_pay_later')
    //               ->orWhere('payment_type_remarks', 'applied_program');
    //     })
    //     ->whereIn('user_id', $students)
    //     ->join('users', 'users.id', '=', 'payments_link.user_id') // Assuming relationship through `program_id`

    //     ->paginate(15);




    //     // dd($program_applied);
    //     // $program_applied = PaymentsLink::with([
    //     //     'program:id,name,school_id',
    //     //     'program.university_name:id,university_name',
    //     //     'payments'
    //     // ])
    //     // ->when(auth()->user()->role == 'student', function ($query) {
    //     //     $query->where(function ($q) {
    //     //         $q->where('payment_type_remarks', 'applied_program_pay_later')
    //     //           ->orWhere('payment_type_remarks', 'applied_program');
    //     //     });
    //     // })
    //     // ->whereIn('payments_link.user_id', $students)
    //     // ->join('program', 'program.id', '=', 'payments_link.program_id') // Assuming relationship through `program_id`
    //     // ->distinct('payments_link.user_id')  // Ensure distinct programs based on their name
    //     // ->get();


    //    //dd($program_applied);

    //   return view('admin.applied-program',compact('program_applied','table_three_sixtee','applied_application','visa_application'));
    // }




public function total_applied_program(Request $request)
{
    $user = Auth::user();
    if ($user->admin_type === 'student') {
        $studentIds = Student::where('user_id', $user->id)->pluck('user_id');
        if ($studentIds->isEmpty()) {
            abort(404);
        }
    } elseif ($user->admin_type === 'Administrator') {
        $studentIds = Student::pluck('user_id');
    } else {
        $ownerIds = [$user->id];
        if ($user->hasRole('agent')) {
            $ownerIds = User::where('added_by', $user->id)->whereNotIn('admin_type', ['student'])->pluck('id')->all();
            $ownerIds[] = $user->id;
        }
        $studentIds = Student::whereIn('added_by', $ownerIds)->pluck('user_id');
    }

    $query = \App\Support\AppliedProgramQuery::forStudents($studentIds);
    if ($request->filled('first_name')) {
        $query->where('users.name', 'LIKE', '%' . $request->first_name . '%');
    }
    if ($request->filled('email')) {
        $query->where('users.email', 'LIKE', '%' . $request->email . '%');
    }
    $program_applied = $query->orderByDesc('id')->paginate(10)->withQueryString();

    // Load the supporting information once for the visible page.
    $rows = $program_applied->getCollection();
    $creatorIds = $rows->flatMap(fn ($row) => [$row->assigned_to, $row->added_by_agent_id])->filter()->unique();
    $creatorEmails = User::whereIn('id', $creatorIds)->pluck('email', 'id');
    $userIds = $rows->pluck('user_id')->filter()->unique();
    $programIds = $rows->pluck('program_id')->filter()->unique();
    $courseStatuses = DB::table('tbl_three_sixtee_course_status')->whereIn('user_id', $userIds)->whereIn('course_id', $programIds)
        ->get(['user_id', 'course_id', 'course_remarks'])->groupBy(fn ($row) => $row->user_id . ':' . $row->course_id);
    $visaStatuses = DB::table('tbl_three_sixtee')->whereIn('user_id', $userIds)->whereIn('cource_details', $programIds)
        ->get(['user_id', 'cource_details', 'visa_application'])->groupBy(fn ($row) => $row->user_id . ':' . $row->cource_details);

    return view('admin.applied-program', compact('program_applied', 'creatorEmails', 'courseStatuses', 'visaStatuses'));
}

    public function edit_score_program($id)
    {

        // $score = DB::table('program_english_required')->where('id', $id)->first();

        // $program_id = $score->program_id;
        $score = DB::table('program_english_required')->where('program_id', $id)->first();

        if ($score) {
            // The $score exists, now you can safely access $score->program_id
            $program_id = $score->program_id;
        } else {
            // The record was not found
            // You can handle the case when $score is null, e.g., show an error message
            echo "Record not found.";
        }


        $eng_proficiency_level = EngProficiencyLevel::paginate(12);
        $data = DB::table('program_english_required')->leftJoin('eng_proficiency_levels', 'eng_proficiency_levels.id', '=', 'program_english_required.type')->where('program_id', $id)->select('program_english_required.*', 'eng_proficiency_levels.name')->get();
        $program = Program::findOrFail($id);
        return view('admin.program.edit-score', compact('score', 'eng_proficiency_level', 'data', 'program'));
    }

    public function score_prog_add(Request $request, $id)
    {

        $check = ProgramEnglishRequired::where("program_id", $id)->where("type", $request->type)->first();
        if ($check) {

            $reqScore = DB::table('program_english_required')
                ->updateOrInsert(
                    ['program_id' => $id, 'type' => $request->type],
                    [
                        'program_id' => $id,
                        'type' => $request->type,
                        'listening_score' => $request->listening_score,
                        'writing_score' => $request->writing_score,
                        'reading_score' => $request->reading_score,
                        'speaking_score' => $request->speaking_score,
                        'overall_score' => $request->overall_score,
                        'remarks' => $request->remarks,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );

            flash()->error("Selected Exam is already assigned to this program !");
            return redirect()->back()->withInput();
        }


        if ($request->program_eng_id != '') {
            $programEnglishRequired = ProgramEnglishRequired::findOrFail($request->program_eng_id);
            // dd( $programEnglishRequired);
            $msg = 'Required Score has been successfully updated.';
        } else {
            $programEnglishRequired = new ProgramEnglishRequired;
            $msg = 'Required Score has been successfully added.';
        }

        $programEnglishRequired->type = $request->type;
        $programEnglishRequired->listening_score = $request->listening_score;
        $programEnglishRequired->writing_score = $request->writing_score;
        $programEnglishRequired->reading_score = $request->reading_score;
        $programEnglishRequired->speaking_score = $request->speaking_score;
        $programEnglishRequired->overall_score = $request->overall_score;
        $programEnglishRequired->program_id = $id;
        $programEnglishRequired->remarks = $request->remarks ??  null;

        $programEnglishRequired->save();

        flash()->message($msg);


        return redirect()->back();
        // return response()->json(['status' => true, 'success' => 'Data Inserted Successfully', 'program_id' => $request->program_id]);
    }


    public function delete_score_program($id)
    {

        $score = DB::table('program_english_required')->where('id', $id)->first();
        $program_id = $score->program_id;
        if ($score) {
            $deleteScore = DB::table('program_english_required')->where('id', $id)->delete();
            // return response()->json(['status' => true, 'success' => 'Data Deleted Successfully', 'program_id' => $program_id]);
            $msg = 'Required Score has been Deleted successfully.';
            flash()->error($msg);
            return redirect()->back();
        } else {
            return redirect()->back();
            // return response()->json(['status' => false, 'success' => 'Data Not Exist', 'program_id', $program_id]);
        }
    }


    public function update_program_month(Request $request)
    {


        $program = Program::with('study_type', 'educationLevel', 'programLevel', 'currency_data', 'ProgramCategory', 'school')
            ->whereHas('school', function ($query) use ($request) {
                if ($request->univerisity_name) {
                    $query->where('university_name', 'LIKE', "%{$request->univerisity_name}%");
                }
            })->latest();
        $user = Auth::user();
        if (!($user->hasRole('Administrator'))) {
            //$program->where('user_id',$user->id);
        }
        if ($request->program_name) {
            $program->where('name', 'LIKE', "%{$request->program_name}%");
        }
        if ($request->approve_status == 'approve') {
            $program->where('is_approved', 1);
        } else if ($request->approve_status == 'unapprove') {
            $program->where('is_approved', 0);
        }
        $program = $program->whereDate('updated_at', '<', Carbon::now()->subMonths(2))->paginate(12);

        $eng_proficiency_level = EngProficiencyLevel::get();
        return view('admin.program.program_month', compact('program', 'eng_proficiency_level'));

        // $oldprogram = Program::whereDate('updated_at', '<', Carbon::now()->subMonths(3))->paginate(12);

        // return view('admin.program.program_month',compact('oldprogram'));
    }
  
   public function toggleApproval(Request $request)
    {
        $item = Program::find($request->id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->is_approved = $request->status;
        $item->save();
        self::forgetProgramStatsCache();

        return response()->json([
            'message' => $request->status ? 'Approved Successfully' : 'Unapproved Successfully'
        ]);
    }
}
