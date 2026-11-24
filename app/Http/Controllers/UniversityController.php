<?php

namespace App\Http\Controllers;

use App\Models\{Country, Program, SchoolReview, SchoolType, University,PaymentsLink,User,Student};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Cache, DB, Route, URL};
use Carbon\Carbon;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    public function manage_university(Request $request)
    {
        $countries = Country::all();
        $results = University::with('country', 'province');
        $route = Route::currentRouteName();
        $originUrl = url('');
        $currentUrl = URL::current();
        $user =Auth::user();
         if(!($user->hasRole('Administrator') || $user->hasRole('Data oprator') || $user->hasRole('Sub Data-Operator')|| $user->hasRole('Digital Marketing')) ){
            $results->where('user_id', $user->id);
        }
        if ($request->has('university_name') && $request->university_name != '') {
            $results->where('university_name', 'LIKE', "%{$request->university_name}%");
        }
        if ($request->from_date) {
            $results->whereDate('updated_at', '>=', $request->from_date);
        }
        
        if ($request->to_date) {
            $results->whereDate('updated_at', '<=', $request->to_date);
        }
        if ($request->user_id) {
            $results->where('user_id',  $request->user_id);
        }
        if ($request->has('country') && $request->country != '') {
            $results->where('country_id', $request->country);
        }
        if ($request->has('account_type') && $request->account_type != '') {
            $isApproved = $request->account_type == 'approve' ? 1 : 0;
            $results->where('is_approved', $isApproved);
        }
        if ($request->has('status') && $request->status != '') {
            $results->where('status', $request->status);
        }
        $results=$results->latest()->paginate(12);
     
        $users = User::whereIn('admin_type', ['Sub Data-Operator', 'Data oprator'])->where('is_approve', 1)->get();
       
        return view('admin.university.manage-university', compact('countries','results','users'));

    }

    public function view_approve_university(Request $request)
    {
        $countries = Country::all();
        $results = University::with('country', 'province')->where('is_approved',1);
        $route = Route::currentRouteName();
        $originUrl = url('');
        $currentUrl = URL::current();
        $user =Auth::user();
         if(!($user->hasRole('Administrator') || $user->hasRole('Data oprator') || $user->hasRole('Sub Data-Operator') || $user->hasRole('Digital Marketing'))){
            $results->where('user_id', $user->id);
        }
        if ($request->has('university_name') && $request->university_name != '') {
            $results->where('university_name', 'LIKE', "%{$request->university_name}%");
        }
        if ($request->has('country') && $request->country != '') {
            $results->where('country_id', $request->country);
        }
        if ($request->has('status') && $request->status != '') {
            $results->where('status', $request->status);
        }
        $results=$results->latest()->paginate(12);
        return view('admin.university.approved-university', compact('countries','results'));
    }

    public function view_unapprove_university(Request $request)
    {
        $countries = Country::all();
        $results = University::with('country', 'province')->where(function ($query) {
                        $query->whereNull('is_approved')->orWhere('is_approved',0);
                    });
        $route = Route::currentRouteName();
        $originUrl = url('');
        $currentUrl = URL::current();
        $user =Auth::user();
          if(!($user->hasRole('Administrator') || $user->hasRole('Data oprator') || $user->hasRole('Sub Data-Operator'))){
            $results->where('user_id', $user->id);
        }
        if ($request->has('university_name') && $request->university_name != '') {
            $results->where('university_name', 'LIKE', "%{$request->university_name}%");
        }
        if ($request->has('country') && $request->country != '') {
            $results->where('country_id', $request->country);
        }
        if ($request->has('status') && $request->status != '') {
            $results->where('status', $request->status);
        }
        $results=$results->latest()->paginate(12);
        return view('admin.university.unapproved-university', compact('countries','results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_university()
    {
        [$college_type, $currency, $countries, $testrequired] = $this->wizardMasterLists();

        return view('admin.university.create-university', compact('college_type', 'currency', 'countries', 'testrequired'));
    }

    private function wizardMasterLists()
    {
        $college_type = Cache::remember('wizard_schooltypes_active', 600, function () {
            return SchoolType::where('active', 1)->orderBy('position')->get(['id', 'name']);
        });
        $currency = Cache::remember('wizard_currencies', 600, function () {
            return DB::table('currencies')->get(['id', 'currency']);
        });
        $countries = Cache::remember('wizard_countries', 600, function () {
            return Country::orderBy('name')->get(['id', 'name']);
        });
        $testrequired = Cache::remember('wizard_testrequired', 600, function () {
            return \App\Models\EngProficiencyLevel::get(['id', 'name']);
        });

        return [$college_type, $currency, $countries, $testrequired];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  
  
     public function store_university(Request $request)
    {
       
        if ($request->tab1) {

            $validator = Validator::make($request->all(), [
                'country_id' => 'required|max:200',
                'province_id' => 'required|max:200',
                'university_location' => 'required|max:200',
                'city' => 'required|max:200',
                'zip' => 'required|max:200',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $uniSave = University::updateOrCreate(
                ['id' => $request->university_id],
                [
                    'country_id' => $request->country_id,
                    'state' => $request->province_id,
                    'university_location' => $request->university_location,
                    'city' => $request->city,
                    'zip' => $request->zip,
                    'map_location' => $request->map_location,
                    'last_updated_by' => Auth::id(),
                ]
            );

            if ($uniSave->wasRecentlyCreated) {
                // Brand-new wizard: starts life as a draft (excluded from
                // every tab/count/public query) until step 5 submits it.
                $uniSave->update(['is_draft' => 1, 'user_id' => Auth::id()]);
            }

            UniversityController::forgetUniversityStatsCache();

            return response()->json([
                'status' => true,
                'university_id' => $uniSave->id,
                'is_draft' => (bool) $uniSave->is_draft,
            ]);
        }

                    /* =========================
                TAB 2 : UNIVERSITY DETAILS
                ==========================*/
        if ($request->tab2) {

            if (!$request->university_id) {
                return response()->json([
                    'status' => false,
                    'errors' => 'Please create university first'
                ], 422);
            }

            // Trim name to avoid duplicate by spaces
            $request->merge([
                'university_name' => trim($request->university_name)
            ]);

            $validator = Validator::make($request->all(), [

                'university_name' => [
                    'required',
                    'max:200',
                    Rule::unique('universities', 'university_name')
                        ->ignore($request->university_id),
                ],

                'type_of_university' => 'required|max:200',
                'founded_in' => 'required|max:200',
                'total_students' => 'required|max:200',
                'international_students' => 'required|max:200',
                'size_of_campus' => 'required|max:200',
                'male_female_ratio' => 'required|max:200',
                'faculty_student_ratio' => 'required|max:200',
                'expense_amount' => 'required|max:200',
                'expense_currencies' => 'required|max:200',
                'financial_aid' => 'required|max:200',
                'accomodation' => 'required|max:200',
                'website2' => 'required|max:200',
                'website' => 'required',
                'application_cost' => 'required',
                'application_cost_currencies' => 'required',
                'fafsa_code' => 'required',
                'testrequired_input' => 'required',

            ], [
                'university_name.unique' => 'University name already exists.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            /* ===== Test Required Handling ===== */
            if (is_array($request->testrequired_input)) {
                $testrequired = implode(',', $request->testrequired_input);
            } else {
                $testrequired = $request->testrequired_input ?? '';
            }

            /* ===== Added By / Added On: auto-filled, original kept on edit ===== */
            $existingAddedByName = University::where('id', $request->university_id)->value('added_by_name');
            $addedByValues = empty($existingAddedByName)
                ? ['added_by_name' => Auth::user()->name, 'added_on_date' => now()]
                : [];

            $uniSave = University::updateOrCreate(
                ['id' => $request->university_id],
                $addedByValues + [
                    'user_id' => Auth::id(),
                    'university_name' => $request->university_name,
                    'university_slug' => Str::slug($request->university_name),
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'details' => $request->details,
                    'website' => $request->website,
                    'type_of_university' => $request->type_of_university,
                    'founded_in' => $request->founded_in,
                    'total_students' => $request->total_students,
                    'international_students' => $request->international_students,
                    'size_of_campus' => $request->size_of_campus,
                    'male_female_ratio' => $request->male_female_ratio,
                    'faculty_student_ratio' => $request->faculty_student_ratio,
                    'yearly_hostel_expense_amount' => $request->expense_amount,
                    'yearly_hostel_expense_currencies' => $request->expense_currencies,
                    'financial_aid' => $request->financial_aid,
                    'placement' => $request->placement,
                    'accomodation' => $request->accomodation,
                    'accomodation_details' => $request->accomodation_details,
                    'website2' => $request->website2,
                    'application_cost' => $request->application_cost,
                    'application_cost_currencies' => $request->application_cost_currencies,
                    'fafsa_code' => $request->fafsa_code,
                    'testrequired' => $testrequired,
                    'notes' => $request->notes,
                    'status' => 1,
                    'last_updated_by' => Auth::id(),
                ]
            );
            UniversityController::forgetUniversityStatsCache();

            return response()->json([
                'status' => true,
                'university_id' => $uniSave->id,
            ]);
        }
    }
  
    public function store_university_old(Request $request)
    {
        if($request->tab1){
                $validator = Validator::make($request->all(), [
                    'country_id' => 'required|max:200',
                    'province_id' => 'required|max:200',
                    'university_location' => 'required|max:200',
                    'city' => 'required|max:200',
                    'zip' => 'required|max:200',
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
                }
                $uniSave = University::updateOrCreate(
                    ['id' => $request->university_id],
                    [
                        'country_id' => $request->country_id,
                        'state' => $request->province_id,
                        'university_location' => $request->university_location,
                        'city' => $request->city,
                        'zip' => $request->zip,
                        'map_location' => $request->map_location
                    ]);
                $data = [
                    'status' => true,
                    'university_id' => $uniSave->id,
                ];
                return response()->json($data);
        }elseif($request->tab2){
            if($request->university_id){
                $validator = Validator::make($request->all(), [
                  
                    'university_name' =>'required|max:200',
                    'type_of_university' => 'required|max:200',
                    'founded_in' => 'required|max:200',
                    'total_students' => 'required|max:200',
                    'international_students' => 'required|max:200',
                    'size_of_campus' => 'required|max:200',
                    'male_female_ratio' => 'required|max:200',
                    'faculty_student_ratio' => 'required|max:200',
                    'expense_amount' => 'required|max:200',
                    'expense_currencies' => 'required|max:200',
                    'financial_aid' => 'required|max:200',
                    'accomodation' => 'required|max:200',
                    'website2' => 'required|max:200',
                    'website'=>'required',
                    'application_cost' => 'required',
                    'fafsa_code' => 'required',
                    'added_by_name' => 'required',
                    'added_on_date' => 'required',
                    'testrequired_input'=>'required',
                    'application_cost_currencies'=>'required',
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
                }
                $slugs = Str::slug($request->university_name);
                $id=Auth::user()->id;
                $tst_type = gettype($request->testrequired_input);
                if($tst_type == "string"){
                    $testrequired = $request->testrequired_input;
                } else {
                    if(isset($request->testrequired_input)){
                        $testrequired = implode(",",$request->testrequired_input);
                    } else {
                        $testrequired = "";
                    }
                }
                $uniSave = University::updateOrCreate(
                    ['id' => $request->university_id],
                    [
                        'user_id' => $id,
                        'university_name' => $request->university_name,
                        'university_slug' => $slugs,
                        'phone_number' => $request->phone_number,
                        'email' => $request->email,
                        'details' => $request->details,
                        'website' => $request->website,
                        'type_of_university' => $request->type_of_university,
                        'founded_in' => $request->founded_in,
                        'total_students' => $request->total_students,
                        'international_students' => $request->international_students,
                        'size_of_campus' => $request->size_of_campus,
                        'male_female_ratio' => $request->male_female_ratio,
                        'faculty_student_ratio' => $request->faculty_student_ratio,
                        'yearly_hostel_expense_amount' => $request->expense_amount,
                        'yearly_hostel_expense_currencies' => $request->expense_currencies,
                        'financial_aid' => $request->financial_aid,
                        'placement' => $request->placement,
                        'accomodation' => $request->accomodation,
                        'accomodation_details' => $request->accomodation_details,
                        'website2' => $request->website2,
                        'application_cost' => $request->application_cost,
                        'application_cost_currencies' => $request->application_cost_currencies,
                        'fafsa_code' => $request->fafsa_code,
                        'testrequired' => $testrequired,
                        'added_by_name' => $request->added_by_name,
                        'notes' => $request->notes,
                        'added_on_date' => $request->added_on_date,
                        'created_at' => date('Y-m-d H:i:s'),
                        'status' => 1
                    ]
                );
                $data = [
                    'status' => true,
                    'university_id' => $uniSave->id,
                ];
            }else{
                return response()->json(['status' => false, 'errors' => 'Please Create university'], 422);
            }
            return response()->json($data);
        }
    }

    public function add_uni_ranking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ranking' => 'required|max:200',
            'from_place' => 'required|max:200',
            'year' => 'required|max:200',
            'type' => 'required|max:200',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }
        if($request->university_id){
            $uniSave = DB::table('university_ranking')
                ->insert([
                    'ranking' => $request->ranking,
                    'from_place' => $request->from_place,
                    'year' => $request->year,
                    'type' => $request->type,
                    'university_id' => $request->university_id,
                    'status' => '1',
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $data = [
                    'status' => true,
                    'university_id' => $request->university_id,
                ];
            return response()->json($data);
        }else{
            return response()->json(['status' => false, 'errors' => 'Please Create University'], 422);
        }

    }

    public function all_uni_ranking(Request $request, $id = null)
    {
        $id = $id ?? $request->id;
        $data = $id ? DB::table('university_ranking')->where('university_id', $id)->orderBy('id', 'DESC')->get() : null;
        return response()->json($data);
    }



    public function delete_uni_ranking($id)
    {
        $record = DB::table('university_ranking')->where('id',$id)->first();
        if($record){
            $data = DB::table('university_ranking')->where('id',$id)->delete();
            return redirect()->back()->with('success','University Ranking Deleted Successfully');
        }else{
            return redirect()->back()->with('error','Record Not Found');
        }
    }

    public function add_uni_accerediation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'year' => 'required|max:200',
            'company_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }
        if($request->university_id){
            if ($request->company_logo) {
                    $company_logo = $request->file('company_logo');
                    $imageName = time() . '_' . $company_logo->getClientOriginalName();
                    $imagePath = 'imagesapi/' . $imageName;
                    $company_logo->move(public_path('imagesapi/'), $imageName);
            }
            $uniSave = DB::table('university_accerediations')
            ->insert([
                'name' => $request->name,
                'year' => $request->year,
                'university_id' => $request->university_id,
                'logo'=> $imagePath,
                'status' => '1',
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $data = [
                'status' => true,
                'university_id' => $request->university_id,
            ];
            return response()->json($data);
        }else{
            return response()->json(['status' => false, 'errors' => 'Please Create University'], 422);
        }

    }

    public function all_uni_accerediation(Request $request, $id = null)
    {
        $id = $id ?? $request->id;
        $data = $id ? DB::table('university_accerediations')->where('university_id', $id)->orderBy('id', 'DESC')->get() : null;
        return response()->json($data);
    }

    public function delete_uni_accerediation($id)
    {
       $data = DB::table('university_accerediations')->where('id',$id)->first();
       if($data){
            DB::table('university_accerediations')->where('id',$id)->delete();
            return redirect()->back()->with('success','University Accerediation Deleted Successfully');
       }else{
            return redirect()->back()->with('error','University Accerediation Not Found');
       }
    }

    /* =========================================================
       Wizard (Add/Edit University) additions: edit + AJAX delete
       for Ranking/Accreditation, and the draft lifecycle.
       ========================================================= */

    public function updateRankingAjax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ranking' => 'required|max:200',
            'from_place' => 'required|max:200',
            'year' => 'required|max:200',
            'type' => 'required|max:200',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        DB::table('university_ranking')->where('id', $id)->update([
            'ranking' => $request->ranking,
            'from_place' => $request->from_place,
            'year' => $request->year,
            'type' => $request->type,
            'updated_at' => now(),
        ]);

        return response()->json(['status' => true]);
    }

    public function deleteRankingAjax($id)
    {
        $record = DB::table('university_ranking')->where('id', $id)->first();
        if (!$record) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }
        DB::table('university_ranking')->where('id', $id)->delete();

        return response()->json(['status' => true]);
    }

    public function updateAccerediationAjax(Request $request, $id)
    {
        $record = DB::table('university_accerediations')->where('id', $id)->first();
        if (!$record) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'year' => 'required|max:200',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $update = [
            'name' => $request->name,
            'year' => $request->year,
            'updated_at' => now(),
        ];

        if ($request->hasFile('company_logo')) {
            $logo = $request->file('company_logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('imagesapi/'), $logoName);
            $update['logo'] = 'imagesapi/' . $logoName;
        }

        DB::table('university_accerediations')->where('id', $id)->update($update);

        return response()->json(['status' => true]);
    }

    public function deleteAccerediationAjax($id)
    {
        $record = DB::table('university_accerediations')->where('id', $id)->first();
        if (!$record) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }
        DB::table('university_accerediations')->where('id', $id)->delete();

        return response()->json(['status' => true]);
    }

    public function submitUniversityWizard(Request $request)
    {
        $request->validate(['university_id' => 'required|integer|exists:universities,id']);

        $university = University::findOrFail($request->university_id);
        $university->update(['is_draft' => 0]);
        self::forgetUniversityStatsCache();

        return response()->json(['status' => true, 'university_id' => $university->id]);
    }

    public function draftsList(Request $request)
    {
        $drafts = University::where('is_draft', 1)
            ->where('user_id', Auth::id())
            ->orderByDesc('updated_at')
            ->get(['id', 'university_name', 'updated_at']);

        return response()->json([
            'drafts' => $drafts->map(function ($d) {
                return [
                    'id' => $d->id,
                    'name' => $d->university_name ?: 'Untitled draft',
                    'updated_at' => $d->updated_at->diffForHumans(),
                ];
            }),
        ]);
    }

    public function add_uni_documents_old(Request $request,$id=null)
    {
        if($request->university_id){
            $uniDoc = DB::table('universities')->where('id', $request->university_id)->first();
            $validator = Validator::make($request->all(), [
                'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                //'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'banner' => 'required|image|mimes:jpeg,png,jpg|max:6048',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
            }
            if($request->logo){
                $logo = $request->file('logo');
                $logoName = time() . '_' . $logo->getClientOriginalName();
                $logoPath = 'imagesapi/' . $logoName;
                $logo->move(public_path('imagesapi/'), $logoName);
            }
            if($request->thumbnail){
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
                $thumbnailPath = 'imagesapi/' . $thumbnailName;
                $thumbnail->move(public_path('imagesapi/'), $thumbnailPath);
            }
            if($request->banner){
                $banner = $request->file('banner');
                $bannerName = time() . '_' . $banner->getClientOriginalName();
                $bannerPath = 'imagesapi/' . $bannerName;
                $banner->move(public_path('imagesapi/'), $bannerPath);
            }
            if ($request->images) {
                $images = $request->file('images');
                foreach ($images as $uploadedImage) {
                    $imageName = time() . '_' . $uploadedImage->getClientOriginalName();
                    $imagePath = 'imagesapi/' . $imageName;
                    $uploadedImage->move(public_path('imagesapi/'), $imageName);
                    DB::table('university_galary_images')
                    ->insert([
                        'file_name' => $imagePath,
                        'university_id' => $request->university_id,
                        'mime_type'=> '',
                        'status' => '1',
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            $uniUpd = DB::table('universities')
                ->where('id',$request->university_id)
                ->update([
                    'logo' => $logoPath,
                    'banner' => $bannerPath,
                    //'thumbnail'=> $thumbnailPath,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            $data = [
                'status' => true,
                'university_id' => $request->university_id,
            ];
           return response()->json($data);
        }else{
            return response()->json(['status' => false, 'errors' => 'Please Create University'], 422);
        }
    }
  
   public function add_uni_documents(Request $request)
    {
        if (!$request->university_id) {
            return response()->json(['status' => false, 'errors' => 'Please Create University'], 422);
        }    
       $validator = Validator::make($request->all(), [
            'logo' => '|image|mimes:jpeg,png,jpg|max:100',
            'thumbnail' => 'image|mimes:jpeg,png,jpg|max:100',
            'banner' => '|image|mimes:jpeg,png,jpg|max:100',
         
            // 'images.*' => 'image|mimes:jpeg,png,jpg|max:100',
            ], [
                'logo.max' => 'Logo must be less than 100KB',
                'thumbnail.max' => 'Thumbnail must be less than 100KB',
                'banner.max' => 'Banner must be less than 100KB',
                // 'images.*.max' => 'Each image must be less than 100KB',
            ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }
    
        $logoPath = null;
        $thumbnailPath = null;
        $bannerPath = null;
    
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logoPath = 'imagesapi/' . $logoName;
            $logo->move(public_path('imagesapi/'), $logoName);
        }
    
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnailPath = 'imagesapi/' . $thumbnailName;
            $thumbnail->move(public_path('imagesapi/'), $thumbnailName);
        }
    
        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $bannerName = time() . '_' . $banner->getClientOriginalName();
            $bannerPath = 'imagesapi/' . $bannerName;
            $banner->move(public_path('imagesapi/'), $bannerName);
        }
    
        // Save gallery images
        if ($request->hasFile('images')) {
            
            foreach ($request->file('images') as $uploadedImage) {
                $imageName = time() . '_' . $uploadedImage->getClientOriginalName();
                $imagePath = 'imagesapi/' . $imageName;
                $uploadedImage->move(public_path('imagesapi/'), $imageName);

                 DB::table('university_galary_images')->insert([
                    'file_name' => $imagePath,
                    'university_id' => $request->university_id,
                    'mime_type' => '',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    
        // Update university document paths
        $updateData = [];
        if ($logoPath) $updateData['logo'] = $logoPath;
        if ($thumbnailPath) $updateData['thumbnail'] = $thumbnailPath;
        if ($bannerPath) $updateData['banner'] = $bannerPath;
    
        if (!empty($updateData)) {
            $updateData['updated_at'] = now();
            DB::table('universities')->where('id', $request->university_id)->update($updateData);
       
        }
    
        return response()->json([
            'status' => true,
            'success' => 'University documents updated successfully!',
            'university_id' => $request->university_id
        ]);
    }
    public function deleteGalleryImage(Request $request)
    {
        

        // Fetch gallery record
        $gallery = DB::table('university_galary_images')->where('id', $request->id)->first();

        if ($gallery) {
            // Build full path to image
            $filePath = public_path($gallery->file_name);

            // If file exists, delete it
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete database record
            DB::table('university_galary_images')->where('id', $request->id)->delete();
        }

        return response()->json(['success' => true]);
    }

    public function university_document(Request $request)
    {
          $uniDoc = DB::table('universities')->Select('logo','banner','thumbnail')->where('id',$request->id)->first();
        $university_gallery = DB::table('university_galary_images')->select('file_name','status','id')->where('university_id',$request->id)->get();
        $data = [
            'status' => true,
            'uniDoc' => $uniDoc,
            'university_gallery' => $university_gallery,
        ];
        
        return response()->json($data);
    }


    public function delete_university($id)
    {
        $university = University::find($id);
        if ($university) {
            $university->delete();
            $data = [
                'status' => true,
                'message' => 'University deleted successfully',
            ];
            return redirect()->route('manage-university')->with(['status' => false,'success','University Deleted Successfully']);
        } else {
            return redirect()->route('manage-university')->with(['status' => false,'success','University not found']);
        }
    }


    public function edit_university($id){
        $university = University::findOrFail($id);

        [$college_type, $currency, $countries, $testrequired] = $this->wizardMasterLists();

        return view('admin.university.edit-university', compact('college_type', 'university', 'currency', 'countries', 'testrequired'));
    }

    public function approve_university(Request $request)
    {
        University::findOrFail($request->university_id)->update(['is_approved' => $request->selectedValue]);
        return response()->json(['message' => 'Approve updated successfully']);
    }


  public function update_university()
{
    $user = Auth::user();

    // Start base query
    $query = University::query();

    // Restrict non-admins to only their own entries
    if (!($user->hasRole('Administrator') || $user->hasRole('Data operator') || $user->hasRole('Sub Data-Operator'))) {
        $query->where('user_id', $user->id);
    }

    // Filter universities not updated in the last 3 months
    $oldUniversities = $query->whereDate('updated_at', '<', now()->subMonths(3))->paginate(12);

    return view('admin.university.updation-university', compact('oldUniversities'));
}



    public function oel_review(Request $request)
    {
        $reviews = SchoolReview::query();
        if ($request->application_id) {
            $reviews = $reviews->where('school_id', $request->application_id);
        }
        if (isset($request->status)) {
            $reviews = $reviews->where('status', $request->status);
        }
        $reviews = $reviews->paginate(12);
        return view('admin.university.oel-review', compact('reviews'));
    }

    public function add_review(){
        return view('admin.university.create-review');
    }

    public function store_oel_review(Request $request){
        $this->validate($request, [
            'school_id' => 'required|numeric',
            'heading' => 'required',
            'details' => 'required',
            'status'=>'required'
        ]);
        SchoolReview::create([
            'school_id' => $request->school_id,
            'heading' => $request->heading,
            'details' => $request->details,
            'status' => $request->status,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return redirect()->route('oel-review')->with('success','Review Added Successfully');
    }

    public function edit_oel_review($id){
        $review = SchoolReview::findOrFail($id);
        return view('admin.university.edit-review', compact('review'));
    }

    public function update_oel_review(Request $request, $id){
        $review = SchoolReview::findOrFail($id);
        $review->update([
            'school_id' => $request->school_id,
            'heading' => $request->heading,
            'details' => $request->details,
            'status' => $request->status,
            'updated_at' => Carbon::now(),
        ]);
        return redirect()->route('oel-review')->with('success','Review Updated Successfully');
    }

    public function delete_oel_review($id){
        if(SchoolReview::find($id)){
            SchoolReview::find($id)->delete();
            return redirect()->route('oel-review')->with('success','Review Deleted Successfully');
        }else{
            return redirect()->route('oel-review')->with('error','Review Not Found');
        }
    }

    public function oel_type(Request $request){
        $name = SchoolType::query();
        if ($request->name) {
            $name = $name->where('name', 'like', '%' . $request->name . '%');
        }
        $data = $name->paginate(12);
        return view('admin.university.oel-type', compact('data'));
    }

    public function add_type(){
        return view('admin.university.create-type');
    }

    public function store_oel_type(Request $request){
        $this->validate($request, [
            'name' => 'required',
        ]);
        SchoolType::create([
            'name' => $request->name,
            'active' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return redirect()->route('oel-type')->with('success','Type Added Successfully');
    }

    public function edit_oel_type($id){
        $data = SchoolType::findOrFail($id);
        return view('admin.university.edit-type', compact('data'));
    }

    public function update_oel_type(Request $request, $id){
        $data = SchoolType::findOrFail($id);
        $data->update([
            'name' => $request->name,
            'updated_at' => Carbon::now(),
        ]);
        return redirect()->route('oel-type')->with('success','Type Updated Successfully');
    }

    public function delete_oel_type($id){
        if(SchoolType::find($id)){
            SchoolType::find($id)->delete();
            return redirect()->route('oel-type')->with('success','Type Deleted Successfully');
        }else{
            return redirect()->route('oel-type')->with('error','Type Not Found');
        }
    }

   /**
    * Legacy entry point. Every resolvable request 301s to the canonical
    * study-in.university URL instead of rendering here directly.
    */
   public function view_university(Request $request, $slug)
{
    $about_university = null;
    $universityId = null;

    if (ctype_digit($slug)) {
        $universityId = $slug;
    } elseif (preg_match('/-(\d+)$/', $slug, $matches)) {
        $universityId = $matches[1];
    }

    if ($universityId) {
        $about_university = University::where('id', $universityId)->first();
    }

    if (!$about_university && !ctype_digit($slug)) {
        $universityName = str_replace('-', ' ', urldecode($slug));
        $about_university = University::where('university_name', $universityName)->first();
    }

    // 🔥 Prevent null error in Blade
    if (!$about_university) {
        abort(404);
    }

    return redirect()->route('study-in.university', $this->buildStudyInUniversitySlugs($about_university), 301);
}

    private const UNIVERSITY_PROGRAM_PAGE_SIZE = 20;

    public function studyInUniversity(Request $request, $country, $university)
    {
        $universityId = null;
        if (preg_match('/(\d+)$/', $university, $matches)) {
            $universityId = $matches[1];
        }

        if (!$universityId) {
            abort(404);
        }

        $about_university = Cache::remember("university_details_{$universityId}", 600, function () use ($universityId) {
            return University::with([
                'country:id,name',
                'province:id,name',
                'university_type:id,name'
            ])->where('id', $universityId)->first();
        });

        if (!$about_university) {
            abort(404);
        }

        $canonical = $this->buildStudyInUniversitySlugs($about_university);
        if ($country !== $canonical['country'] || $university !== $canonical['university']) {
            return redirect()->route('study-in.university', $canonical, 301);
        }

        $totalPrograms = Cache::remember("university_{$about_university->id}_total_programs", 3600, function () use ($about_university) {
            return Program::where('school_id', $about_university->id)->where('is_approved', 1)->count();
        });

        $programQuery = Program::with(
            'university_name:id,logo,website,university_name,country_id',
            'programSubLevel:program_id,name,id',
            'educationLevelprogram:name,id,program_level_id,program_sublevel_id',
            'educationLevel',
            'currency_data:id,currency',
            'programLevel:id,name'
        )
        ->where('school_id', $about_university->id)
        ->where('is_approved', 1)   // ✅ ONLY APPROVED PROGRAMS
        ->when($request->program_name, function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->program_name.'%');
        })
        ->orderBy('id');

        if ($request->ajax()) {
            $page = max(1, (int) $request->input('page', 1));
            $programs = (clone $programQuery)->skip(($page - 1) * self::UNIVERSITY_PROGRAM_PAGE_SIZE)->take(self::UNIVERSITY_PROGRAM_PAGE_SIZE)->get();
            $filteredTotal = (clone $programQuery)->count();

            return response()->json([
                'data' => $programs->values(),
                'has_more' => $filteredTotal > $page * self::UNIVERSITY_PROGRAM_PAGE_SIZE,
            ]);
        }

        $filteredTotal = (clone $programQuery)->count();
        $program = $programQuery->take(self::UNIVERSITY_PROGRAM_PAGE_SIZE)->get();
        $hasMorePrograms = $filteredTotal > self::UNIVERSITY_PROGRAM_PAGE_SIZE;

        return view('frontend.university-details', compact('about_university', 'program', 'totalPrograms', 'filteredTotal', 'hasMorePrograms'));
    }

    private function buildUniversityDetailSlug($university)
    {
        return Str::slug($university->university_name) . '-' . $university->id;
    }

    private function buildStudyInUniversitySlugs($university)
    {
        return [
            'country' => Str::slug($university->country->name ?? 'unknown'),
            'university' => $this->buildUniversityDetailSlug($university),
        ];
    }

    /* =========================================================
       Unified Universities page
       Tabs: all | approved | unapproved | needs-update | reviews | types
       ========================================================= */

    private const UNIVERSITY_TABS = ['all', 'approved', 'unapproved', 'needs-update', 'reviews', 'types'];
    private const STALE_EXPR = 'GREATEST(updated_at, COALESCE(last_verified_at, updated_at))';

    private function universityTabPermission(string $tab): string
    {
        return match ($tab) {
            'approved' => 'approve_university.approve_university_view',
            'unapproved' => 'un_approve_university.un_approve_university_view',
            'needs-update' => 'updation_manage_university.updation_manage_university_view',
            'reviews' => 'oel_review.oel_review_view',
            'types' => 'oel_type.oel_type_view',
            default => 'manage_university.manage_university_view',
        };
    }

    private function normalizeUniversityTab($tab): string
    {
        $tab = $tab ?: 'all';
        if ($tab === 'updates') {
            $tab = 'needs-update';
        }
        return in_array($tab, self::UNIVERSITY_TABS, true) ? $tab : 'all';
    }

    private function visibleUniversityTabs()
    {
        $user = Auth::user();
        return collect(self::UNIVERSITY_TABS)->filter(function ($tab) use ($user) {
            return $user->can($this->universityTabPermission($tab));
        })->values();
    }

    public function redirectManageUniversity(Request $request)
    {
        return redirect()->route('universities.index', ['tab' => 'all'] + $request->query());
    }

    public function redirectApprovedUniversity(Request $request)
    {
        return redirect()->route('universities.index', ['tab' => 'approved'] + $request->query());
    }

    public function redirectUnapprovedUniversity(Request $request)
    {
        return redirect()->route('universities.index', ['tab' => 'unapproved'] + $request->query());
    }

    public function redirectNeedsUpdateUniversity(Request $request)
    {
        return redirect()->route('universities.index', ['tab' => 'needs-update'] + $request->query());
    }

    public function redirectOelReview(Request $request)
    {
        return redirect()->route('universities.index', ['tab' => 'reviews'] + $request->query());
    }

    public function redirectOelType(Request $request)
    {
        return redirect()->route('universities.index', ['tab' => 'types'] + $request->query());
    }

    public function universitiesHub(Request $request)
    {
        $tab = $this->normalizeUniversityTab($request->get('tab'));
        $visibleTabs = $this->visibleUniversityTabs();
        abort_if($visibleTabs->isEmpty(), 403);
        if (!$visibleTabs->contains($tab)) {
            $tab = $visibleTabs->first();
        }

        $stats = self::universityStats();

        return view('admin.university.universities', compact('tab', 'visibleTabs', 'stats'));
    }

    public function universitiesPanel(Request $request, $tab)
    {
        $tab = $this->normalizeUniversityTab($tab);
        abort_unless(Auth::user()->can($this->universityTabPermission($tab)), 403);

        switch ($tab) {
            case 'approved':
                return $this->panelUniversityList($request, 1);
            case 'unapproved':
                return $this->panelUniversityList($request, 0);
            case 'needs-update':
                return $this->panelNeedsUpdate($request);
            case 'reviews':
                return $this->panelReviews($request);
            case 'types':
                return $this->panelTypes($request);
            default:
                return $this->panelUniversityList($request, null);
        }
    }

    private function scopeUniversityByOwner($query, array $exemptRoles = ['Administrator', 'Data oprator', 'Sub Data-Operator', 'Digital Marketing'])
    {
        $user = Auth::user();
        foreach ($exemptRoles as $role) {
            if ($user->hasRole($role)) {
                return $query;
            }
        }
        return $query->where('user_id', $user->id);
    }

    private function panelUniversityList(Request $request, $approvalFilter)
    {
        $query = University::query()
            ->where('is_draft', 0)
            ->select(['id', 'university_name', 'university_slug', 'country_id', 'state', 'city', 'type_of_university', 'is_approved', 'status', 'user_id', 'updated_at'])
            ->with(['country:id,name', 'province:id,name', 'university_type:id,name']);

        if ($approvalFilter === 1) {
            $query->where('is_approved', 1);
            $this->scopeUniversityByOwner($query);
            $tabKey = 'approved';
        } elseif ($approvalFilter === 0) {
            $query->where(function ($q) {
                $q->whereNull('is_approved')->orWhere('is_approved', 0);
            });
            $this->scopeUniversityByOwner($query, ['Administrator', 'Data oprator', 'Sub Data-Operator']);
            $tabKey = 'unapproved';
        } else {
            $this->scopeUniversityByOwner($query);
            $tabKey = 'all';
        }

        if ($request->filled('university_name')) {
            $query->where('university_name', 'LIKE', '%' . $request->university_name . '%');
        }
        if ($request->filled('country')) {
            $query->where('country_id', $request->country);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type_of_university', $request->type);
        }
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('updated_at', [$request->from_date, $request->to_date]);
        } elseif ($request->filled('from_date')) {
            $query->whereDate('updated_at', '>=', $request->from_date);
        } elseif ($request->filled('to_date')) {
            $query->whereDate('updated_at', '<=', $request->to_date);
        }

        $universities = $query->latest('updated_at')->paginate(20)->appends($request->query());

        $countries = Cache::remember('master_countries', 600, function () {
            return Country::select('id', 'name')->orderBy('name')->get();
        });
        $types = Cache::remember('master_schooltypes_active', 600, function () {
            return SchoolType::select('id', 'name')->where('active', 1)->orderBy('position')->get();
        });

        return view('admin.university.partials.panel-list', compact('universities', 'countries', 'types', 'tabKey'));
    }

    private function panelNeedsUpdate(Request $request)
    {
        $staleDays = (int) config('oel.stale_days', 90);
        $cutoff3 = now()->subDays($staleDays);
        $cutoff6 = now()->subDays($staleDays * 2);
        $cutoff12 = now()->subDays(365);

        $query = University::query()
            ->where('is_draft', 0)
            ->select(['id', 'university_name', 'university_slug', 'email', 'phone_number', 'logo', 'website', 'type_of_university', 'country_id', 'state', 'updated_at', 'last_verified_at', 'last_updated_by'])
            ->with(['lastUpdatedBy:id,name'])
            ->whereRaw(self::STALE_EXPR . ' < ?', [$cutoff3]);

        $this->scopeUniversityByOwner($query, ['Administrator', 'Sub Data-Operator']);

        $age = $request->get('age');
        if ($age === '6') {
            $query->whereRaw(self::STALE_EXPR . ' < ?', [$cutoff6]);
        } elseif ($age === '12') {
            $query->whereRaw(self::STALE_EXPR . ' < ?', [$cutoff12]);
        }

        $universities = $query->orderByRaw(self::STALE_EXPR . ' ASC')->paginate(20)->appends($request->query());

        return view('admin.university.partials.panel-needs-update', compact('universities', 'staleDays'));
    }

    private function panelReviews(Request $request)
    {
        $query = SchoolReview::query()->with(['university:id,university_name', 'student:id,first_name,last_name']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('university_id')) {
            $query->where('school_id', $request->university_id);
        }

        $reviews = $query->latest()->paginate(20)->appends($request->query());

        return view('admin.university.partials.panel-reviews', compact('reviews'));
    }

    private function panelTypes(Request $request)
    {
        $query = SchoolType::query()->withCount('universities');
        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
        $types = $query->orderBy('position')->orderBy('id')->get();

        return view('admin.university.partials.panel-types', compact('types'));
    }

    public function toggleUniversityApproval(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'status' => 'required|in:0,1']);
        $university = University::findOrFail($request->id);
        $university->update(['is_approved' => $request->status]);
        self::forgetUniversityStatsCache();

        return response()->json(['message' => $request->status ? 'Approved Successfully' : 'Unapproved Successfully']);
    }

    public function bulkToggleUniversityApproval(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer', 'status' => 'required|in:0,1']);
        $count = University::whereIn('id', $request->ids)->update(['is_approved' => $request->status]);
        self::forgetUniversityStatsCache();

        return response()->json(['message' => "Updated {$count} universities.", 'count' => $count]);
    }

    public function markUniversityVerified(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        University::where('id', $request->id)->update(['last_verified_at' => now()]);
        self::forgetUniversityStatsCache();

        return response()->json(['message' => 'Marked as verified.']);
    }

    public function bulkMarkUniversityVerified(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer']);
        $count = University::whereIn('id', $request->ids)->update(['last_verified_at' => now()]);
        self::forgetUniversityStatsCache();

        return response()->json(['message' => "Marked {$count} universities as verified.", 'count' => $count]);
    }

    public function searchStudents(Request $request)
    {
        $search = trim((string) $request->get('q'));

        $students = Student::query()
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                });
            })
            ->limit(20)
            ->get(['id', 'first_name', 'last_name', 'email']);

        return response()->json([
            'results' => $students->map(function ($s) {
                $name = trim(($s->first_name ?? '') . ' ' . ($s->last_name ?? ''));
                return ['id' => $s->id, 'text' => $name . ($s->email ? " ({$s->email})" : '')];
            }),
        ]);
    }

    public function storeTypeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required|max:191',
            'description' => 'nullable|string',
        ]);
        $maxPosition = (int) SchoolType::max('position');
        $type = SchoolType::create([
            'name' => $request->name,
            'description' => $request->description,
            'position' => $maxPosition + 1,
            'active' => 1,
        ]);
        self::forgetUniversityStatsCache();

        return response()->json(['status' => true, 'type' => $type]);
    }

    public function updateTypeAjax(Request $request, $id)
    {
        $type = SchoolType::findOrFail($id);
        $request->validate([
            'name' => 'required|max:191',
            'description' => 'nullable|string',
        ]);
        $type->update(['name' => $request->name, 'description' => $request->description]);
        self::forgetUniversityStatsCache();

        return response()->json(['status' => true, 'type' => $type]);
    }

    public function deleteTypeAjax($id)
    {
        $type = SchoolType::findOrFail($id);
        $inUseCount = University::where('type_of_university', $id)->count();
        if ($inUseCount > 0) {
            return response()->json([
                'status' => false,
                'message' => "Cannot delete: {$inUseCount} " . ($inUseCount === 1 ? 'university uses' : 'universities use') . ' this type.',
            ], 422);
        }
        $type->delete();
        self::forgetUniversityStatsCache();

        return response()->json(['status' => true]);
    }

    public function toggleTypeActiveAjax(Request $request, $id)
    {
        $type = SchoolType::findOrFail($id);
        $type->update(['active' => $request->boolean('active') ? 1 : 0]);

        return response()->json(['status' => true]);
    }

    public function reorderTypesAjax(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer']);
        $ids = $request->ids;
        if (empty($ids)) {
            return response()->json(['status' => true]);
        }

        $cases = [];
        $params = [];
        foreach ($ids as $index => $id) {
            $cases[] = 'WHEN ? THEN ?';
            $params[] = $id;
            $params[] = $index;
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = 'UPDATE schooltype SET position = CASE id ' . implode(' ', $cases) . ' END WHERE id IN (' . $placeholders . ')';
        DB::update($sql, array_merge($params, $ids));

        return response()->json(['status' => true]);
    }

    public function storeReviewAjax(Request $request)
    {
        $data = $request->validate([
            'school_id' => 'required|integer|exists:universities,id',
            'student_id' => 'nullable|integer|exists:student,id',
            'reviewer_name' => 'nullable|max:191',
            'rating' => 'nullable|integer|min:1|max:5',
            'heading' => 'required|max:191',
            'details' => 'required',
            'status' => 'required|in:0,1',
        ]);
        $review = SchoolReview::create($data);
        self::forgetUniversityStatsCache();

        return response()->json(['status' => true, 'review' => $review]);
    }

    public function updateReviewAjax(Request $request, $id)
    {
        $review = SchoolReview::findOrFail($id);
        $data = $request->validate([
            'school_id' => 'required|integer|exists:universities,id',
            'student_id' => 'nullable|integer|exists:student,id',
            'reviewer_name' => 'nullable|max:191',
            'rating' => 'nullable|integer|min:1|max:5',
            'heading' => 'required|max:191',
            'details' => 'required',
            'status' => 'required|in:0,1',
        ]);
        $review->update($data);
        self::forgetUniversityStatsCache();

        return response()->json(['status' => true, 'review' => $review]);
    }

    public function approveReviewAjax($id)
    {
        SchoolReview::where('id', $id)->update(['status' => 1]);
        self::forgetUniversityStatsCache();

        return response()->json(['status' => true]);
    }

    public function universitiesStatsJson()
    {
        $stats = self::universityStats();
        $visibleTabs = $this->visibleUniversityTabs();

        return response()->json(['stats' => $stats, 'visibleTabs' => $visibleTabs]);
    }

    public static function universityStats()
    {
        return Cache::remember('university_stats', 300, function () {
            $staleDays = (int) config('oel.stale_days', 90);
            $cutoff = now()->subDays($staleDays);

            return [
                'total' => University::where('is_draft', 0)->count(),
                'approved' => University::where('is_draft', 0)->where('is_approved', 1)->count(),
                'unapproved' => University::where('is_draft', 0)->where(function ($q) {
                    $q->whereNull('is_approved')->orWhere('is_approved', 0);
                })->count(),
                'needs_update' => University::where('is_draft', 0)->whereRaw(self::STALE_EXPR . ' < ?', [$cutoff])->count(),
                'reviews_pending' => SchoolReview::where('status', 0)->count(),
                'reviews_total' => SchoolReview::count(),
                'types_total' => SchoolType::count(),
                'drafts' => University::where('is_draft', 1)->count(),
            ];
        });
    }

    public static function forgetUniversityStatsCache()
    {
        Cache::forget('university_stats');
        Cache::forget('master_countries');
        Cache::forget('master_schooltypes_active');
        Cache::forget('wizard_schooltypes_active');
    }
}
