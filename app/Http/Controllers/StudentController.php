<?php

namespace App\Http\Controllers;

use App\Models\{
    Country,
    EducationHistory,
    EducationLevel,
    MasterService,
    PopularStudentGuide,
    Payment,
    PaymentsLink,
    Program,
    SchoolAttended,
    Scholarship,
    Student,
    StudentApplyQuestions,
    StudentAssistance,
    StudentAttendence,
    StudentByAgent,
    StudentRegistrationFees,
    Subject,
    University,
    User,
    ProgramSubLevel
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentLinkEmail;
use App\Models\Documents;
use App\Models\EngProficiencyLevel;
use App\Models\ProgramLevel;
use App\Models\AdditionalQualification;
use Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function student_list1(Request $request)
    // {
        
    //     $user = Auth::user();
    //     $query = Student::with('country', 'province');
   
    //     if ($request->name) {
    //         $query->where('first_name', 'like', '%' . $request->name . '%');
    //     }
    //     if ($request->email) {
    //         $query->where('email', 'like', '%' . $request->email . '%');
    //     }
    //     if ($request->phone_number) {
    //         $query->where('phone_number', 'like', '%' . $request->phone_number . '%');
    //     }
    //     if ($request->zip) {
    //         $query->where('zip', 'like', '%' . $request->zip . '%');
    //     }
    //     if ($request->country_id) {
    //         $query->where('country_id', $request->country_id);
    //     }
    //     if ($request->from_date && $request->to_date) {
    //         $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
    //     }
    //     if ($user->hasRole('Administrator') ) {

    //         $query = $query;
           
    //     } 
    //     if( $user->hasRole('Application Punching') ) {

    //         $query = $query;
          
    //     }

    //     if ( $user->hasRole('visa')) {
    //         $studentData = Student::query();
           
    //         $queryy = $studentData
    //         ->join('users', 'users.id', '=', 'student.added_by')
    //         ->join('student_by_agent', 'student_by_agent.student_user_id', '=', 'student.user_id')
    //         ->join('payments', 'payments.customer_email', '=', 'student.email')
    
    //         ->join('tbl_three_sixtee', 'tbl_three_sixtee.sba_id', '=', 'student.id')
    //         ->join('payments_link', 'payments_link.fallowp_unique_id', '=', 'payments.fallowp_unique_id')
    //         ->where('student.status_threesixty', 1)
    //         ->where('student.profile_complete', 1)
    //         ->where('tbl_three_sixtee.application_punching', 1)
    //         ->select(
    //             'student.email',
    //             'student.user_id',
    //             'student.first_name',
    //             'student.last_name',
    //             'student.status_threesixty',
    //             'student.profile_complete',
    //             DB::raw('MAX(users.name) as added_by_name'),
    //             DB::raw('MAX(users.email) as added_by_email'),
    //             DB::raw('MAX(payments.id) as payment_id'),
    //             DB::raw('MAX(payments.amount) as payment_amount'),
    //             DB::raw('MAX(payments.payment_status) as payment_status'),
               
    //             DB::raw('MAX(tbl_three_sixtee.visa_application) as visa_application'),
    //             DB::raw('MAX(tbl_three_sixtee.application_punching) as application_punching')

    //         )
    //         ->groupBy(
    //             'student.email',
    //             'student.user_id',
    //             'student.first_name',
    //             'student.last_name',
    //             'student.status_threesixty',
    //             'student.profile_complete'
    //         )
    //         ;

    //         $query = $queryy->paginate(15);
    //     }
    //     else {
           
    //         $authuser = Auth::user();
    //         if (($authuser->hasRole('agent'))) {
    //             $userId = Auth::id();
    //             $usersId = User::where('added_by', $userId)->whereNotIn('admin_type', ['student'])
    //                 ->pluck('id')->toArray();
    //             if (!empty($usersId)) {
    //                 array_push($usersId, $user->id);
    //             }
    //         } else {
    //             $usersId = [$user->id];
    //         }
    //         $query->whereIn('added_by', $usersId)
    //             ->paginate(12);
    //     }
    //     if ($user->hasRole('Application Punching')) {
    //         $query->where('profile_complete', '1');
    //     }
    //     $student_profile = $query->paginate(12);

        

    //     $master_service = MasterService::select('name', 'id')->get();
    //     return view('admin.student.index', compact('student_profile', 'master_service'));
    // }


    public function workspaceCaseFragment(Request $request, string $id)
    {
        return $this->student_list($request, $id);
    }

    public function student_list(Request $request, ?string $caseId = null)
    {
        $user = Auth::user();
        [$view, $query] = $this->workspaceListQuery($request);
        $selected = null;
        $studentId = $caseId ?? $request->query('student');
        if ($studentId !== null) {
            $scopeRequest = new Request(['view' => $view === 'ready' ? 'ready' : 'all']);
            [, $scope] = $this->workspaceListQuery($scopeRequest);
            $allowed = $scope->where('student.user_id', $studentId)->first();
            abort_unless($allowed, 404);
            $selected = Student::with('country', 'province')->where('user_id', $allowed->user_id)->firstOrFail();
        }
        $tab = $request->query('tab', $view === 'ready' && $selected ? 'payments' : 'overview');
        $step = $request->integer('step', 0);
        abort_unless($step >= 0 && $step <= 11, 404);
        abort_unless(in_array($tab, ['overview', 'documents', 'applications', 'payments', 'journey'], true), 404);
        $details = collect();
        $owner = null;
        $account = null;
        $visaStatuses = collect();
        $courseStatuses = collect();
        $latestApplication = null;
        $journeyData = null;
        $summary = null;
        $totals = null;
        $universities = collect();
        $duplicatePaymentIds = [];
        $masterServices = collect();
        $paymentUniversities = collect();
        if ($selected) {
            $summary = DB::table('tbl_three_sixtee')->where('sba_id', $selected->id)->orderByDesc('id')->first([
                'college', 'courses', 'application', 'cource_details', 'joining_date', 'fee_amount', 'visa_apply_date',
                'visa_application', 'flight_name', 'flight_no', 'hand_holding', 'hostel',
            ]);
            if ($summary?->college) {
                $universities = DB::table('universities')->whereIn('id', explode(',', $summary->college))->pluck('university_name');
            }
            $mayViewPayments = $user->can('application.view') && (
                $user->hasRole('Administrator') || $selected->added_by == $user->id ||
                ($user->hasRole('agent') && User::where('added_by', $user->id)->whereNotIn('admin_type', ['student'])->where('id', $selected->added_by)->exists())
            );
            if ($mayViewPayments && $selected->email) {
                $totals = $this->paymentLedgerQuery($selected->email)
                    ->selectRaw("COUNT(*) AS entries, SUM(CASE WHEN payments_link.payment_type_remarks = 'applied_program_pay_later' THEN 0 ELSE payments_link.amount END) AS paid, SUM(CASE WHEN payments_link.payment_type_remarks = 'applied_program_pay_later' THEN payments_link.amount ELSE 0 END) AS due")
                    ->first();
            }
            $owner = User::find($selected->added_by);
            $account = User::where('email', $selected->email)->first();
            if ($tab === 'journey') {
                abort_unless($user->can('oel_360.view') && $user->can('oel_apply.view'), 403);
                abort_unless($selected->profile_complete, 403);
                $journeyView = app(LeadsManageCotroller::class)->aply_360($selected->user_id);
                abort_unless($journeyView->name() === 'admin.leads.apply_oel_360', 404);
                $journeyData = $journeyView->getData();
            } elseif ($tab === 'documents') {
                abort_unless($user->can('oel_360.view'), 403);
                $details = DB::table('student_documents')->leftJoin('documents', 'student_documents.document_type', '=', 'documents.id')->where('student_documents.student_id', $selected->id)->select('documents.name', 'student_documents.image_url')->get();
            } elseif ($tab === 'applications') {
                abort_unless($user->can('application.view'), 403);
                $allowedOwners = $user->hasRole('Administrator') ? null : [$user->id];
                if ($user->hasRole('agent')) {
                    $allowedOwners = User::where('added_by', $user->id)->whereNotIn('admin_type', ['student'])->pluck('id')->all();
                    $allowedOwners[] = $user->id;
                }
                abort_if($allowedOwners !== null && !in_array($selected->added_by, $allowedOwners), 403);
                $details = \App\Support\AppliedProgramQuery::forStudents(collect([$selected->user_id]))->orderByDesc('id')->limit(25)->get();
                $programIds = $details->pluck('program_id');
                $visaStatuses = DB::table('tbl_three_sixtee')->where('user_id', $selected->user_id)->whereIn('cource_details', $programIds)->get()->keyBy('cource_details');
                $courseStatuses = DB::table('tbl_three_sixtee_course_status')->where('user_id', $selected->user_id)->whereIn('course_id', $programIds)->get()->keyBy('course_id');
            } elseif ($tab === 'payments') {
                abort_unless($user->can('application.view'), 403);
                $allowedOwners = $user->hasRole('Administrator') ? null : [$user->id];
                if ($user->hasRole('agent')) {
                    $allowedOwners = User::where('added_by', $user->id)->whereNotIn('admin_type', ['student'])->pluck('id')->all();
                    $allowedOwners[] = $user->id;
                }
                abort_if($allowedOwners !== null && !in_array($selected->added_by, $allowedOwners), 403);
                $details = $this->paymentLedgerQuery($selected->email)
                    ->select(
                        'payments_link.id',
                        'payments_link.master_service as master_service_id',
                        'payments_link.amount',
                        'payments_link.discount',
                        'payments_link.remarks',
                        'payments_link.payment_mode as payment_method',
                        'payments_link.created_at',
                        'master_service.name as service_name',
                        DB::raw("IF(payments_link.payment_type_remarks = 'applied_program_pay_later', 'pending', 'success') as payment_status")
                    )
                    ->orderByDesc('payments_link.id')->get();
                $duplicatePaymentIds = $details->where('payment_status', 'success')
                    ->groupBy(fn ($entry) => $entry->master_service_id . '|' . $entry->amount)
                    ->filter(fn ($group) => $group->count() > 1)
                    ->flatMap(fn ($group) => $group->pluck('id'))
                    ->all();
                $masterServices = MasterService::select('id', 'name', 'amount')->orderBy('name')->get();
                $paymentUniversities = collect();
                if ($summary?->college) {
                    $universityIds = array_filter(explode(',', $summary->college));
                    $courseIds = array_filter(explode(',', $summary->courses ?? ''));
                    $coursesByUniversity = $courseIds
                        ? DB::table('program')->whereIn('id', $courseIds)->get()->keyBy('school_id')
                        : collect();
                    $paymentUniversities = DB::table('universities')->whereIn('id', $universityIds)->get()
                        ->map(fn ($uni) => (object) [
                            'id' => $uni->id,
                            'name' => $uni->university_name,
                            'program_id' => $coursesByUniversity->get($uni->id)?->id,
                            'program_name' => $coursesByUniversity->get($uni->id)?->name,
                        ]);
                }
            } else {
                $details = EducationHistory::with('educationLevel')->where('student_id', $selected->id)->first();
                $mayViewApplications = $user->hasRole('Administrator') || $selected->added_by == $user->id || ($user->hasRole('agent') && User::where('added_by', $user->id)->whereNotIn('admin_type', ['student'])->where('id', $selected->added_by)->exists());
                if ($user->can('application.view') && $mayViewApplications) {
                    $latestApplication = \App\Support\AppliedProgramQuery::forStudents(collect([$selected->user_id]))->orderByDesc('id')->first();
                }
            }
        }
        $caseData = compact('view', 'tab', 'step', 'selected', 'details', 'owner', 'account', 'latestApplication', 'visaStatuses', 'courseStatuses', 'journeyData', 'summary', 'totals', 'universities', 'duplicatePaymentIds', 'masterServices', 'paymentUniversities');
        if ($caseId !== null) {
            return response()->view('admin.student.workspace-case', $caseData)->header('Cache-Control', 'private, no-store');
        }

        $student_profile = $this->workspaceListPage($query, $request);
        $agents = User::where('admin_type', 'agent')->when(!$user->hasRole('Administrator'), fn ($q) => $q->where('added_by', $user->id))->get(['id', 'name']);
        $sub_agents = User::where('admin_type', 'sub_agent')->when(!$user->hasRole('Administrator'), fn ($q) => $q->where('added_by', $user->id))->get(['id', 'name']);
        $master_service = MasterService::select('name', 'id')->get();
        return view('admin.student.workspace', $caseData + compact('student_profile', 'agents', 'sub_agents', 'master_service'));
    }

    public function workspaceListFragment(Request $request)
    {
        [$view, $query] = $this->workspaceListQuery($request);

        return response()->view('admin.student.workspace-list', [
            'student_profile' => $this->workspaceListPage($query, $request),
            'selectedId' => $request->query('student'),
        ])->header('Cache-Control', 'private, no-store');
    }

    private function workspaceListQuery(Request $request): array
    {
        $user = Auth::user();
        $view = $request->query('view', $user->can('student.view') ? 'all' : 'ready');
        abort_unless(in_array($view, ['all', 'ready', 'progress', 'visa', 'done', 'incomplete'], true), 404);
        abort_unless($user->can($view === 'ready' ? 'oel_360.view' : 'student.view'), 403);

        if ($view === 'ready') {
            $scope = \App\Support\Oel360ReadyQuery::forUser($user);
        } else {
            [$scope] = $this->workspaceAllQuery(new Request(), true);
        }

        $query = Student::query()->whereIn('student.user_id', $scope->reorder()->select('student.user_id'));
        $query->leftJoin('tbl_three_sixtee as journey', function ($join) {
                $join->on('journey.sba_id', '=', 'student.id')
                    ->whereRaw('journey.id = (select max(id) from tbl_three_sixtee where tbl_three_sixtee.sba_id = student.id)');
            })
            ->select('student.id', 'student.user_id', 'student.first_name', 'student.last_name', 'student.email',
                'student.profile_complete', 'student.status_threesixty', 'journey.college', 'journey.visa_application',
                'journey.hostel', 'journey.flight_no', 'journey.visa_apply_date', 'journey.fee_amount', 'journey.courses');
        if ($request->filled('q')) {
            $term = '%' . $request->input('q') . '%';
            $query->where(function ($query) use ($term) {
                $query->whereRaw("CONCAT_WS(' ', student.first_name, student.last_name) LIKE ?", [$term])
                    ->orWhere('student.email', 'like', $term)
                    ->orWhere('student.phone_number', 'like', $term);
            });
        }
        foreach (['agent_id' => 'added_by_agent_id', 'subagent_id' => 'added_by', 'country_id' => 'country_id'] as $input => $column) {
            if ($request->filled($input)) {
                $query->where('student.' . $column, $request->input($input));
            }
        }
        foreach (['from_date' => '>=', 'to_date' => '<='] as $input => $operator) {
            if ($request->filled($input)) {
                $query->whereDate('student.created_at', $operator, $request->input($input));
            }
        }
        foreach (['first_name' => 'first_name', 'name' => 'first_name', 'email' => 'email', 'phone_number' => 'phone_number', 'zip' => 'zip'] as $input => $column) {
            if ($request->filled($input)) {
                $query->where('student.' . $column, 'like', '%' . $request->input($input) . '%');
            }
        }
        if ($view === 'incomplete') {
            $query->where(fn ($query) => $query->where('student.profile_complete', 0)->orWhereNull('student.profile_complete'));
        } elseif ($view === 'visa') {
            $query->where('journey.visa_application', 'Rejected');
        } elseif ($view === 'done') {
            $query->whereNotNull('journey.hostel')->where('journey.hostel', '!=', '');
        } elseif ($view === 'progress') {
            $query->where('student.profile_complete', 1)->whereNotNull('journey.college')->where('journey.college', '!=', '')
                ->where(fn ($query) => $query->whereNull('journey.hostel')->orWhere('journey.hostel', ''))
                ->where(fn ($query) => $query->whereNull('journey.visa_application')->orWhere('journey.visa_application', '!=', 'Rejected'));
        }

        return [$view, $query->orderByDesc('student.id')];
    }

    private function workspaceListPage($query, Request $request)
    {
        $students = $query->paginate(20);
        $normalizedEmails = $students->pluck('email')->filter()->map(fn ($email) => mb_strtolower(trim($email)))->unique()->values()->all();
        $payments = DB::table('payments_link')
            ->whereNotNull('master_service')
            ->whereIn(DB::raw('LOWER(TRIM(email))'), $normalizedEmails)
            ->groupBy(DB::raw('LOWER(TRIM(email))'))
            ->selectRaw("LOWER(TRIM(email)) AS normalized_email, COUNT(*) AS entries, SUM(CASE WHEN payment_type_remarks = 'applied_program_pay_later' THEN 0 ELSE 1 END) AS paid")
            ->get()->keyBy('normalized_email');
        foreach ($students as $student) {
            $payment = $student->email ? $payments->get(mb_strtolower(trim($student->email))) : null;
            $student->workspace_payment = !$payment ? 'No payments' : ($payment->paid == $payment->entries ? 'Paid' : 'Part paid');
        }

        return $students;
    }

    /**
     * The OEL 360 payment ledger. This is the same payments_link rows the old
     * payment drawer read (filtered by student email, not user_id - payments_link.user_id
     * is not the student's user_id, it doesn't match any student/user/lead id). The match is
     * case- and whitespace-insensitive because the drawer's emails aren't normalized on write.
     * A row is "due" when it came from the student-facing "pay later" apply flow
     * (payment_type_remarks = applied_program_pay_later); every other row was entered by staff
     * after collecting the amount (Cash/Cheque/Bank/Online), so it counts as received.
     */
    private function paymentLedgerQuery(string $email)
    {
        return DB::table('payments_link')
            ->leftJoin('master_service', 'master_service.id', '=', 'payments_link.master_service')
            ->whereRaw('LOWER(TRIM(payments_link.email)) = LOWER(TRIM(?))', [$email])
            ->whereNotNull('payments_link.master_service');
    }

    public function workspaceAllQuery(Request $request, bool $includeIncomplete = false)
    {
        $user = Auth::user();
        $query = Student::query()->when(!$includeIncomplete, fn ($query) => $query->where('profile_complete', 1))
            ->orderBy('created_at', 'desc');
             
        // Filters (common for all roles)
        if ($request->name) {
            $query->where('first_name', 'like', '%' . $request->name . '%');
        }
        if ($request->email) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->phone_number) {
            $query->where('phone_number', 'like', '%' . $request->phone_number . '%');
        }
        if ($request->zip) {
            $query->where('zip', 'like', '%' . $request->zip . '%');
        }
        if ($request->country_id) {
            $query->where('country_id', $request->country_id);
        }
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }
        
        // Role-based access control
        if ($user->hasRole('Administrator')) {
            // Admin sees everything
            $perPage = 15;
        
        } elseif ($user->hasRole('visa')) {
            // Visa officer sees filtered joined data
            $query = Student::query()
                ->join('users', 'users.id', '=', 'student.added_by')
                ->join('student_by_agent', 'student_by_agent.student_user_id', '=', 'student.user_id')
                ->join('payments', 'payments.customer_email', '=', 'student.email')
                ->join('tbl_three_sixtee', 'tbl_three_sixtee.sba_id', '=', 'student.id')
                ->join('payments_link', 'payments_link.fallowp_unique_id', '=', 'payments.fallowp_unique_id')
                ->where('student.status_threesixty', 1)
                ->where('student.profile_complete', 1)
                ->where('tbl_three_sixtee.application_punching', 1)
                ->where('tbl_three_sixtee.cource_details', '!=', null)

                ->select(
                    'student.email',
                    'student.user_id',
                    'student.first_name',
                    'student.last_name',
                    'student.status_threesixty',
                    'student.profile_complete',
                    DB::raw('MAX(users.name) as added_by_name'),
                    DB::raw('MAX(users.email) as added_by_email'),
                    DB::raw('MAX(payments.id) as payment_id'),
                    DB::raw('MAX(payments.amount) as payment_amount'),
                    DB::raw('MAX(payments.payment_status) as payment_status'),
                    DB::raw('MAX(tbl_three_sixtee.visa_application) as visa_application'),
                    DB::raw('MAX(tbl_three_sixtee.application_punching) as application_punching')
                )
                ->groupBy(
                    'student.email',
                    'student.user_id',
                    'student.first_name',
                    'student.last_name',
                    'student.status_threesixty',
                    'student.profile_complete'
                );
        
            $perPage = 15;
        
        } elseif ($user->hasRole('Application Punching')) {
             
              //Application Punching only sees complete profiles
           
              $query = Student::query()
              ->join('users', 'users.id', '=', 'student.added_by')
              ->join('student_by_agent', 'student_by_agent.student_user_id', '=', 'student.user_id')
              ->join('payments', 'payments.customer_email', '=', 'student.email')
              ->join('tbl_three_sixtee', 'tbl_three_sixtee.sba_id', '=', 'student.id')
              ->join('payments_link', 'payments_link.fallowp_unique_id', '=', 'payments.fallowp_unique_id')
              ->where('student.status_threesixty', 1)
              ->where('student.profile_complete', 1)
              ->where('payments_link.master_service', 2)
            //   ->where('tbl_three_sixtee.application_punching', null)
              ->select(
                  'student.email',
                  'student.user_id',
                  'student.first_name',
                  'student.last_name',
                  'student.status_threesixty',
                  'student.profile_complete',
                  DB::raw('MAX(users.name) as added_by_name'),
                  DB::raw('MAX(users.email) as added_by_email'),
                  DB::raw('MAX(payments.id) as payment_id'),
                  DB::raw('MAX(payments.amount) as payment_amount'),
                  DB::raw('MAX(payments.payment_status) as payment_status'),
                  DB::raw('MAX(tbl_three_sixtee.visa_application) as visa_application'),
                  DB::raw('MAX(tbl_three_sixtee.application_punching) as application_punching'),
                  DB::raw('MAX(payments_link.master_service) as master_service')
              )
              ->groupBy(
                  'student.email',
                  'student.user_id',
                  'student.first_name',
                  'student.last_name',
                  'student.status_threesixty',
                  'student.profile_complete'
              );
          
          $perPage = 12;
          
        
        } else {
            // Agent or other role
            if ($user->hasRole('agent')) {
                $userId = Auth::id();
                $usersId = User::where('added_by', $userId)
                    ->whereNotIn('admin_type', ['student'])
                    ->pluck('id')
                    ->toArray();
        
                $usersId[] = $user->id; // Include the agent
            } else {
                $usersId = [$user->id]; // Others
            }
        
            $query->whereIn('added_by', $usersId);
            $perPage = 12;
        }
        
        if ($request->filled('q')) {
            $term = '%' . $request->input('q') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('student.first_name', 'like', $term)
                    ->orWhere('student.last_name', 'like', $term)
                    ->orWhere('student.email', 'like', $term)
                    ->orWhere('student.phone_number', 'like', $term);
            });
        }
        return [$query, $perPage];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function student_profile()
    {
        $auth_user = Auth::user()->id;
        if (empty($auth_user)) {
            abort(404);
        }
        $about_student = Student::with('country', 'province')->where('user_id', $auth_user)->first();
        $education_history = EducationHistory::with('country', 'educationLevel', 'gradingScheme')->where('student_id', $about_student->id)->first();
        $student = DB::table('student')->select('id')->where('user_id', $auth_user)->first();
        if (empty($student)) {
            abort(404);
        }
        $student_id = $student->id;
        $test_score = DB::table('test_scores')->where('student_id', $student_id)->get();
        $attended_school = SchoolAttended::with('country:id,name', 'document', 'educationLevel:id,name,program_level_id,program_sublevel_id', 'Student:id,user_id,first_name,last_name,country_id', 'province')->where('student_id', $student_id)->get();
        $additional_qualification = DB::table('additional_qualification')->where('student_id', $student_id)->whereIn('type', ['GRE', 'GMAT'])->get();
        $student_document = DB::table('student_documents')->where('student_id', $student_id)->get();
        return view('admin.student.myprofile', compact('additional_qualification', 'student_document', 'about_student', 'test_score', 'education_history', 'attended_school'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit_student(Request $request)
    {
        $auth_user = Auth::user()->id;
        $about_student = DB::table('student')->where('user_id', $auth_user)->first();
        if (empty($about_student)) {
            abort(404);
        }
        $countries = Country::all();
        $progLabel = ProgramLevel::All();
        $student_attendence = StudentAttendence::with('country', 'province', 'student')->WHERE('student_id', $about_student->id)->get();
        $additional_qualification = DB::table('additional_qualification')->WHERE('student_id', $about_student->id)->where('type', 'GRE')->first();
        $gmat =  DB::table('additional_qualification')->WHERE('student_id', $about_student->id)->where('type', 'GMAT')->first();
        $test_score = DB::table('test_scores')->where('student_id', $about_student->id)->get();
        $all_subject = Program::first();
        $student_document = DB::table('student_documents')->where('student_id', $auth_user)->get();
        $eng_prof_level = EngProficiencyLevel::where('status', 1)->get();
        $education_history = DB::table('education_history')->where('student_id', $about_student->id)->first();
        $about_student->ielts_waiver = $about_student->ielts_waiver ?? null;
        return view('admin.student.edit_student', compact('education_history', 'eng_prof_level', 'about_student', 'student_document', 'all_subject', 'gmat', 'test_score', 'countries', 'progLabel', 'student_attendence', 'additional_qualification'));
    }

    public function store_student(Request $request)
    {


        
        $student_id = Auth::user()->id;
        if (empty($student_id)) {
            abort(404);
        }
        Cache::forget("apply_program_personalization_{$student_id}");
        $student = Student::where('user_id', $student_id)->first();
        if ($request->tab1) {
            $validator = Validator::make($request->all(), [
                'email' => 'unique:users,email,' . $student_id,
                'first_name' => 'required|max:2000',
                'last_name' => 'required|max:2000',
                'gender' => 'required',
                'passport_number' => 'nullable|regex:/^[a-zA-Z0-9]*$/|max:12',
                'dob' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
            }
            $student_data = [
                "first_name" => $request->first_name,
                "middle_name" =>  $request->middle_name,
                "last_name" =>  $request->last_name,
                'email' => $request->email,
                "gender" => $request->gender,
                "maritial_status" => $request->maritial_status,
                "passport_status" => $request->passport_status,
                "passport_number" =>  $request->passport_number,
                "passport_expiry" =>  $request->passport_expiry,
                "dob" => $request->dob,
                "first_language" => $request->first_language,
                "country_id" => $request->country_id,
                "province_id" => $request->province_id,
                "city" =>  $request->city,
                "address" => $request->address,
                "zip" => $request->zip,
            ];
            if ($request->hasFile('passport_document')) {
                $file = $request->file('passport_document');
                $filename = time() . '_' . $file->getClientOriginalName();
                $passport_image = 'imagesapi/' . $filename;
                $file->move(public_path('imagesapi/'), $filename);
                $student_data['passport_document'] = $passport_image;
                if ($student->passport_document) {
                    $old_image_path = public_path($student->passport_document);
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            }
            DB::table('student')->where('user_id', $student_id)->update($student_data);
            $education_history = DB::table('education_history')->where('student_id', $student->id)->first();
            if ($education_history) {
                DB::table('education_history')->where('student_id', $student->id)->update(['student_id' => $student->id]);
            } else {
                DB::table('education_history')->insert(['student_id' => $student->id]);
            }
            DB::table('users')->where('id', $student_id)->update([
                "name" => $request->first_name,
                'email' => $request->email,
            ]);

            $student_email = Auth::user()->email;
            DB::table('student_by_agent')
                ->Where('email', $student_email)
                ->update([
                    'status_threesixty' => '1',
                    'student_user_id' => $student_id
                ]);
            return response()->json(['success' => 'Data Submitted Successfully']);
        } elseif ($request->tab2) {
            $validator = Validator::make($request->all(), [
                'education_level_id' => 'required',
                'program_sub_level'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
            }
            DB::table('student')->where('user_id', $student_id)->update([
                'pref_countries' => $request->pref_countries
            ]);
            DB::table('education_history')
                ->updateOrInsert(
                    ['student_id' => $student->id],
                    [
                        'education_level_id' => $request->education_level_id,
                        'graduated_recently' => $request->graduated_recently,
                        'program_sub_level'=> implode(',',$request->program_sub_level),
                    ]
                );
            return response()->json(['success' => 'Data Submitted Successfully']);
        } elseif ($request->tab3) {
           
            if ($request->hasFile('working_experience_document')) {
                $file = $request->file('working_experience_document');
                $filename = time() . '_' . $file->getClientOriginalName();
                $working_experience_document = 'imagesapi/' . $filename;
                $file->move(public_path('imagesapi/'), $filename);
                if ($student->working_experience_document) {
                    $old_image_path = public_path($student->working_experience_document);
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            }
            DB::table('student')->where('user_id', $student_id)->update([
                'organization_name' => $request->organization_name,
                'position' => $request->position,
                'job_profile' => $request->job_profile,
                'working_from' => $request->working_from,
                'working_upto' => $request->working_upto,
                'mode_of_selary' => $request->mode_of_selary,
                'working_status' => $request->working_status,
                'work_experience' => $request->work_experience,
                'working_experience_document' => $working_experience_document ?? null,
            ]);
            return response()->json(['success' => 'Data inserted Successfully']);
        } elseif ($request->tab5) {
            
            if ($request->hasFile('visa_documents')) {
                $file = $request->file('visa_documents');
                $filename = time() . '_' . $file->getClientOriginalName();
                $visa_documents = 'imagesapi/' . $filename;
                $file->move(public_path('imagesapi/'), $filename);
                if ($student->visa_documents) {
                    $old_image_path = public_path($student->visa_documents);
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            }
            if ($request->hasFile('study_permit_documents')) {
                $file = $request->file('study_permit_documents');
                $filename = time() . '_' . $file->getClientOriginalName();
                $study_permit_documents = 'imagesapi/' . $filename;
                $file->move(public_path('imagesapi/'), $filename);
                if ($student->study_permit_documents) {
                    $old_image_path = public_path($student->study_permit_documents);
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            }
            DB::table('student')->where('user_id', $student_id)
                ->update([
                    'ever_refused_visa' => $request->ever_refused_visa,
                    'visa_documents' => $visa_documents ?? null,
                    'study_permit' => $request->study_permit,
                    'study_permit_documents' => $study_permit_documents ?? null,
                    'has_visa' => $request->has_visa,
                    'visa_details' => $request->visa_details,
                    'pref_subjects' => $request->subject_input,
                ]);
            return response()->json(['success' => 'Data inserted Successfully']);
        } elseif ($request->tab6) {
            $eudcation_level = EducationHistory::where('student_id', $student->id)->select('education_level_id')->first();
            $document = Documents::where('program_level_id', $eudcation_level->education_level_id)->count();
            if ($request->document) {
                $images = $request->file('document');
                foreach ($images as $uploadedImage) {
                    $imageName = time() . '_' . $uploadedImage->getClientOriginalName();
                    $imagePath = 'imagesapi/' . $imageName;
                    $uploadedImage->move(public_path('imagesapi/'), $imageName);
                    DB::table('student_documents')
                        ->insert([
                            'student_id' => $student->id,
                            'document_type' => $request->visa_document_type,
                            'image_url' => $imagePath,
                            'file_type' => $imageName,
                            'file_client_name' => $imageName,
                            'image_name' => $uploadedImage->getClientOriginalName(),
                        ]);
                    // DB::table('student_documents')
                    // ->updateOrInsert(
                    //     ['student_id' => $student->id, 'document_type' => $request->visa_document_type],
                    //     [
                    //         'image_url' => $imagePath,
                    //         'file_type' => $imageName,
                    //         'file_client_name' => $imageName,
                    //     ]
                    // );
                }
            }
            $student_email = Auth::user()->email;
            DB::table('student_by_agent')
                ->Where('email', $student_email)
                ->update([
                    'status_threesixty' => '1',
                    'student_user_id' => $student_id
                ]);
            DB::table('student')
                ->Where('email', $student_email)
                ->update([
                    'status_threesixty' => '1',
                    'profile_complete' => '1',
                ]);
            $table_data_count = DB::table('student_documents')->where('student_id', $student->id)->where('document_type', '!=', 0)->count();
            if (($table_data_count == $document) || ($table_data_count == ($document + 1))) {
                return response()->json(['status' => true, 'success' => 'Your Profile Completed', 'redirect' => 'user']);
            }
            return response()->json(['status' => true, 'success' => 'Please Submit all Your Data']);
        }
    }

    public function update_attendended_school(Request $request)
    {
        $user_id = Auth::user()->id;
        Cache::forget("apply_program_personalization_{$user_id}");
        $student = DB::table('student')->select('id')->where('user_id', $user_id)->first();
        $student_id = $student->id;
        $school_attended = DB::table('school_attended')
            ->where('student_id', $student_id)
            ->where('documents', $request->lead_documents_id)
            ->where('education_level_id', $request->program_level_id)
            ->first();
        if ($school_attended) {
            DB::table('education_history')->where('student_id', $student_id)->update(['education_level_id' => $request->program_level_id]);
            DB::table('school_attended')
                ->where('student_id', $student_id)
                ->where('documents', $request->lead_documents_id)
                ->where('education_level_id', $request->program_level_id)
                ->update([
                    'documents' => $request->lead_documents_id,
                    'education_level_id' => $request->program_level_id,
                    'name' => $request->name,
                    'primary_language' => $request->primary_language,
                    'attended_from' => $request->attended_from,
                    'attended_to' => $request->attended_to,
                    'degree_awarded' => $request->degree_awarded,
                    'degree_awarded_on' => $request->degree_awarded_on,
                    'country_id' => $request->country_id,
                    'province' => $request->province_id,
                    'city' => $request->city,
                    'postal_zip' => $request->postal_zip,
                    'address' => $request->address,
                    'grading_scheme_id'=>$request->grading_scheme_id,
                    'max_score'=>$request->max_score,
                    'grading_average'=>$request->grading_average
                ]);
        } else {
            $education_history = DB::table('education_history')->where('student_id', $student_id)->first();
            if ($education_history) {
                DB::table('education_history')->where('student_id', $student_id)->update(['education_level_id' => $request->program_level_id]);
            } else {
                DB::table('education_history')->insert(['student_id' => $student_id, 'education_level_id' => $request->program_level_id]);
            }
            DB::table('school_attended')
                ->insert([
                    'student_id' => $student_id,
                    'documents' => $request->lead_documents_id,
                    'education_level_id' => $request->program_level_id,
                    'name' => $request->name,
                    'primary_language' => $request->primary_language,
                    'attended_from' => $request->attended_from,
                    'attended_to' => $request->attended_to,
                    'degree_awarded' => $request->degree_awarded,
                    'degree_awarded_on' => $request->degree_awarded_on,
                    'country_id' => $request->country_id,
                    'province' => $request->province_id,
                    'city' => $request->city,
                    'postal_zip' => $request->postal_zip,
                    'address' => $request->address,
                    'grading_scheme_id'=>$request->grading_scheme_id,
                    'max_score'=>$request->max_score,
                    'grading_average'=>$request->grading_average
                ]);
        }
        $data = [
            'status' => true,
            'success' => 'Data Inserted Successfully',
        ];
        return response()->json($data);
    }

    public function fetch_documents(Request $request)
    {
        $documents = Documents::where('program_level_id', $request->program_level_id)->get();
        $documents_id = Documents::where('program_level_id', $request->program_level_id)->pluck('id');
        if ($request->student_id) {
            $user_id = Auth::user()->id;
            $student = DB::table('student')->select('id')->where('user_id', $user_id)->first();
            $student_id = $student->id;
            $school_attended = SchoolAttended::whereIn('documents', $documents_id)->where('student_id', $student_id)->pluck('documents');
            if ($school_attended) {
                $school_attended = $school_attended;
            } else {
                $school_attended = NULL;
            }
        } else {
            $school_attended = NULL;
        }
        $user_id = auth()->user()->id;
        $student_id_data = Student::where('user_id', $user_id)->pluck('id')->first();
        $disabled_education_history = SchoolAttended::where('student_id', $student_id_data)->pluck('documents')->toArray();
        $program_sub_level=DB::table('education_history')->where('student_id', $student_id_data)->pluck('program_sub_level')->first();
        $selected_program_sublevel=explode(",", $program_sub_level);
        $program_sublevel=ProgramSubLevel::where('program_id', $request->program_level_id)->get();
        return response()->json(['documents' => $documents,'selected_program_sublevel'=>$selected_program_sublevel,'program_sublevel'=>$program_sublevel, 'school_attended' => $school_attended, 'disabled_education_history' => $disabled_education_history]);
    }

    public function get_student_document(Request $request)
    {
        $student_id = Student::where('user_id', Auth::user()->id)->pluck('id')->first();
        $student_documents = DB::table('student_documents')
            ->select('student_documents.id', 'student_documents.student_id','student_documents.document_type', 'documents.name', 'student_documents.image_url')
            ->join('documents', 'student_documents.document_type', '=', 'documents.id')
            ->where('student_documents.student_id', $student_id)->get();
            // dd($student_documents);
        $student_documents_data = DB::table('student_documents')->where('document_type', 0)
            ->where('student_documents.student_id',  $student_id)->get();
        return response()->json(['success' => true, 'documents' => $student_documents, 'student_documents_data' => $student_documents_data]);
    }
    
    public function update_gre_exam_data(Request $request)
    {
        $user_id = Auth::user()->id;
        $student = Student::where('user_id', $user_id)->firstOrFail();
        $student_id = $student->id;
        $test_score = AdditionalQualification::where('student_id', $student_id)
            ->where('type', 'GRE')
            ->first();
        if ($request->result_receive == 0) {
            $dataToUpdate = [
                'student_id' => $student_id,
                'type' => 'GRE',
                'date_of_exam' => $request->date_of_exam,
                'exam_document' => null,
                'result_receive' => $request->result_receive,
                'verbal_score' => null,
                'verbal_rank' => null,
                'quantitative_score' => null,
                'quantitative_rank' => null,
                'writing_score' => null,
                'writing_rank' => null,
                'total_score' => null,
                'total_rank' => null
            ];
        } else {
            $dataToUpdate = [
                'student_id' => $student_id,
                'type' => 'GRE',
                'result_receive' => $request->result_receive,
                'date_of_exam' => $request->date_of_exam,
                'verbal_score' => $request->verbal_score,
                'verbal_rank' => $request->verbal_rank,
                'quantitative_score' => $request->quantitative_score,
                'quantitative_rank' => $request->quantitative_rank,
                'writing_score' => $request->writing_score,
                'writing_rank' => $request->writing_rank,
                'total_score' => $request->total_score,
                'total_rank' => $request->total_rank
            ];
            if ($request->hasFile('exam_document')) {
                $file = $request->file('exam_document');
                $filename = time() . '_' . $file->getClientOriginalName();
                $exam_document = 'imagesapi/' . $filename;
                $file->move(public_path('imagesapi/'), $filename);
                if ($test_score && $test_score->exam_document) {
                    $old_image_path = public_path($test_score->exam_document);
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
                $dataToUpdate['exam_document'] = $exam_document;
            }
        }
        if ($test_score) {
            $test_score->update($dataToUpdate);
        } else {
            AdditionalQualification::create($dataToUpdate);
        }
        return response()->json(['status' => true, 'success' => 'Data updated successfully']);
    }
    public function update_gmat_exam_data(Request $request)
    {
        $user_id = Auth::user()->id;
        $student = Student::where('user_id', $user_id)->firstOrFail();
        $student_id = $student->id;
        $test_score = AdditionalQualification::where('student_id', $student_id)->where('type', 'GMAT')->first();
        if ($request->gmat_result_receive == 0) {
            $dataToUpdate = [
                'student_id' => $student_id,
                'type' => 'GMAT',
                'date_of_exam' => $request->date_of_exam,
                'exam_document' => null,
                'result_receive' => $request->gmat_result_receive,
                'verbal_score' => null,
                'verbal_rank' => null,
                'quantitative_score' => null,
                'quantitative_rank' => null,
                'writing_score' => null,
                'writing_rank' => null,
                'total_score' => null,
                'total_rank' => null
            ];
        } else {
            $dataToUpdate = [
                'student_id' => $student_id,
                'type' => 'GMAT',
                'date_of_exam' => $request->date_of_exam,
                'result_receive' => $request->gmat_result_receive,
                'verbal_score' => $request->verbal_score,
                'verbal_rank' => $request->verbal_rank,
                'quantitative_score' => $request->quantitative_score,
                'quantitative_rank' => $request->quantitative_rank,
                'writing_score' => $request->writing_score,
                'writing_rank' => $request->writing_rank,
                'total_score' => $request->total_score,
                'total_rank' => $request->total_rank
            ];
            if ($request->hasFile('exam_document')) {
                $file = $request->file('exam_document');
                $filename = time() . '_' . $file->getClientOriginalName();
                $exam_document = 'imagesapi/' . $filename;
                $file->move(public_path('imagesapi/'), $filename);
                if ($test_score && $test_score->exam_document) {
                    $old_image_path = public_path($test_score->exam_document);
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
                $dataToUpdate['exam_document'] = $exam_document;
            }
        }
        if ($test_score) {
            $test_score->update($dataToUpdate);
        } else {
            AdditionalQualification::create($dataToUpdate);
        }
        return response()->json(['status' => true, 'success' => 'Data updated successfully']);
    }

    


    public function edit_test_score(Request $request, $id)
    {
        $edit_test_score = DB::table('test_scores')->where('id', $id)->first();
        return response()->json($edit_test_score);
    }
    public function update_test_score(Request $request)
    {
        if ((isset($request->eng_prof_level_result) && $request->eng_prof_level_result == 1) || (isset($request->eng_prof_level_result) && $request->ielts_waiver == 0)) {
            $validator = Validator::make($request->all(), [
                'exam_date' => 'required_without:exam_date_edit',
                'type' => 'required_without:type_edit',
                'listening_score' => 'required_without:listening_score_edit',
                'reading_score' => 'required_without:reading_score_edit',
                'writing_score' => 'required_without:writing_score_edit',
                'speaking_score' => 'required_without:speaking_score_edit',
                'total_score' => 'required_without:total_score_edit',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
            }
        }
        if ($request->update_test_score) {
            $test_score =  DB::table('test_scores')->where('id', $request->test_score_id)->first();
            if ($request->hasFile('exam_document_edit')) {
                $file = $request->file('exam_document_edit');
                $filename = time() . '_' . $file->getClientOriginalName();
                $exam_document_edit = 'imagesapi/' . $filename;
                $file->move(public_path('imagesapi/'), $filename);
                if ($test_score && $test_score->exam_document) {
                    $old_image_path = public_path($test_score->exam_document);
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            }
            DB::table('test_scores')->where('id', $request->test_score_id)->update([
                'student_id' => $test_score->student_id,
                'type' => $test_score->type,
                'exam_date' => $request->exam_date_edit,
                'eng_prof_level_result' => $request->eng_prof_level_result_edit,
                'exam_document' => $exam_document_edit ?? null,
                'listening_score' => $request->listening_score_edit,
                'writing_score' => $request->writing_score_edit,
                'reading_score' => $request->reading_score_edit,
                'speaking_score' => $request->speaking_score_edit,
                'average_score' => $request->average_score_edit,
                'total_score' => $request->total_score_edit,
                'ielts_waiver'=>$request->ielts_waiver_edit,
                'english_marks_check'=>$request->english_marks_check,
                'english_marks'=>$request->english_marks,
                'moi'=>$request->moi
            ]);
            return response()->json(['status' => true, 'success' => 'Data Updated Successfully']);
        }
        $student = Student::where('user_id', auth()->user()->id)->first();
        $student->update([
            'eng_prof_level_result' => $request->eng_prof_level_result,
            'ielts_waiver' => $request->ielts_waiver
        ]);
        $student_id = $student->id;
        $test_score = DB::table('test_scores')
            ->where('student_id', $student_id)
            ->where('type', $request->type)
            ->first();

        if ($test_score == null) {
            if ($request->hasFile('exam_document')) {
                $file = $request->file('exam_document');
                $filename = time() . '_' . $file->getClientOriginalName();
                $exam_document = 'imagesapi/' . $filename;
                $file->move(public_path('imagesapi/'), $filename);
                if ($test_score && $test_score->exam_document) {
                    $old_image_path = public_path($test_score->exam_document);
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            }
            DB::table('test_scores')
                ->insert([
                    'student_id' => $student_id,
                    'type' => $request->type,
                    'exam_date' => $request->exam_date,
                    'eng_prof_level_result' => $request->eng_prof_level_result,
                    'exam_document' => $exam_document ?? null,
                    'listening_score' => $request->listening_score,
                    'writing_score' => $request->writing_score,
                    'reading_score' => $request->reading_score,
                    'speaking_score' => $request->speaking_score,
                    'average_score' => $request->average_score,
                    'ielts_waiver'=>$request->ielts_waiver,
                    'english_marks_check'=>$request->english_marks_check,
                    'english_marks'=>$request->english_marks,
                    'total_score' => $request->total_score,
                    'moi'=>$request->moi
                ]);

            return response()->json(['status' => true, 'success' => 'Data inserted Successfully']);
        } else {
            if ($request->hasFile('exam_document')) {
                $file = $request->file('exam_document');
                $filename = time() . '_' . $file->getClientOriginalName();
                $exam_document = 'imagesapi/' . $filename;
                $file->move(public_path('imagesapi/'), $filename);
                if ($test_score && $test_score->exam_document) {
                    $old_image_path = public_path($test_score->exam_document);
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            }
            DB::table('test_scores')
                ->WHERE('student_id', $student_id)
                ->where('type', $request->type)
                ->update([
                    'student_id' => $student_id,
                    'type' => $request->type,
                    'exam_date' => $request->exam_date,
                    'exam_document' => $request->exam_document ?? null,
                    'eng_prof_level_result' => $request->eng_prof_level_result,
                    'listening_score' => $request->listening_score,
                    'writing_score' => $request->writing_score,
                    'reading_score' => $request->reading_score,
                    'speaking_score' => $request->speaking_score,
                    'average_score' => $request->average_score,
                    'ielts_waiver'=>$request->ielts_waiver,
                    'english_marks_check'=>$request->english_marks_check,
                    'english_marks'=>$request->english_marks,
                    'total_score' => $request->total_score,
                    'moi'=>$request->moi
                ]);
            return response()->json(['status' => true, 'success' => 'Data inserted Successfully']);
        }
    }

    public function fetch_eng_prof_level_score(Request $request)
    {
        $score = EngProficiencyLevel::where('name', $request->eng_prof_level)->select('id', 'number')->where('status', 1)->first();
        return response()->json(['success' => true, 'score' => $score]);
    }
    public function delete_attendended(Request $request, $id)
    {
        $schoolAttended = DB::table('school_attended')->where('id', $id)->first();
        if ($schoolAttended) {
            DB::table('school_attended')->where('id', $id)->delete();
            return response()->json(['success' => 'Deleted Successfully']);
        } else {
            return response()->json(['error' => 'Id is not exist']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function grading_scheme_list(Request $request)
    {
        $country_id = $request->get('country_id');
        $ed_id = $request->get('education_level_id');
        $education_level = DB::table('grading_scheme')->WHERE('education_level_id', $ed_id)->WHERE('country_id', $country_id)->get();
        $data = array(
            "data" => $education_level
        );
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_document(Request $request, $id = null)
    {
        $document = DB::table('student_documents')->where('id', $request->id)->first();
        if ($document) {
            if (file_exists($document->image_url)) {
                unlink($document->image_url);
            }
            DB::table('student_documents')->where('id', $request->id)->delete();
            $data = [
                'success' => 'Deleted Successfully',
            ];
        } else {
            $data = [
                'error' => 'Id is not exist',
            ];
        }
        return response()->json($data);
    }

    public function delete_test_score($id)
    {
        $test_score = DB::table('test_scores')->where('id', $id)->first();
        if ($test_score) {
            DB::table('test_scores')->where('id', $id)->delete();
            $data = [
                'success' => 'Deleted Successfully',
            ];
        } else {
            $data = [
                'error' => 'Id is not exist',
            ];
        }
        return response()->json($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function scholarship(Request $request)
    {
        if ($request->heading) {
            $scholarship = Scholarship::where('heading', 'like', '%' . $request->heading . '%')->paginate(12);
        } else {
            $scholarship = Scholarship::paginate(12);
        }

        return view('admin.scholarship.index', compact('scholarship'));
    }

    public function scholarship_create(Request $request)
    {
        $university = University::paginate(50); // or ->limit(50)->get()
        $program = Program::paginate(50);
    
        return view('admin.scholarship.create', compact('university', 'program'));
    }
    public function scholarship_store(Request $request)
    {
        $request->validate([
            'heading' => 'required|max:222',
            'universty_id' => 'required|max:222',
            'course_id' => 'required|max:222',
            'scholarship_type' => 'required|max:222',
            'offered_by' => 'required|max:222',
            'application_dead_line' => 'required|max:222',
            'no_of_scholarship' => 'required|max:222',
            'scholarship_amount' => 'required|max:222',
            'level_of_study' => 'required|max:222',
            'organization' => 'required|max:222',
            'renewability' => 'required|max:222',
            'international_student_eligibility' => 'required',
        ]);
        Scholarship::create($request->except('_token'));
        return redirect()->route('scholarship')->with('success', 'Scholarship created successfully');
    }

    public function scholarship_edit($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $university = University::get();
        $program = Program::get();
        return view('admin.scholarship.edit', compact('scholarship', 'university', 'program'));
    }

    public function scholarship_update(Request $request, $id)
    {

        $request->validate([
            'heading' => 'required|max:222',
            'universty_id' => 'required|max:222',
            'course_id' => 'required|max:222',
            'scholarship_type' => 'required|max:222',
            'offered_by' => 'required|max:222',
            'application_dead_line' => 'required|max:222',
            'no_of_scholarship' => 'required|max:222',
            'scholarship_amount' => 'required|max:222',
            'level_of_study' => 'required|max:222',
            'organization' => 'required|max:222',
            'renewability' => 'required|max:222',
            'international_student_eligibility' => 'required',
        ]);
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->update($request->except('_token'));
        return redirect()->route('scholarship')->with('success', 'Scholarship updated successfully');
    }

    public function scholarship_delete($id)
    {
        if (Scholarship::find($id)) {
            $scholarship = Scholarship::findOrFail($id);
            $scholarship->delete();
            return redirect()->route('scholarship')->with('success', 'Scholarship deleted successfully');
        } else {
            return redirect()->route('scholarship')->with('success', 'Scholarship not deleted successfully');
        }
    }



    // student registration fees

    public function student_registration_fees(Request $request)
    {
        if ($request->has('fees_type')) {
            $student_registraion_fees = StudentRegistrationFees::where('fees_type', 'like', '%' . $request->fees_type . '%')->paginate(12);
        } else {
            $student_registraion_fees = StudentRegistrationFees::paginate(12);
        }
        return view('admin.student.student-registraion-fees.index', compact('student_registraion_fees'));
    }

    public function student_registration_fees_create()
    {
        return view('admin.student.student-registraion-fees.create');
    }

    public function student_registration_fees_store(Request $request)
    {
        $request->validate([
            'fees_type' => 'required|max:222',
            'fees_amount' => 'required|max:222',
        ]);
        StudentRegistrationFees::create($request->all());
        return redirect()->route('student-registration-fees')->with('success', 'Student registration fees created successfully');
    }

    public function student_registration_fees_edit($id)
    {
        $student_registraion_fees = StudentRegistrationFees::findOrFail($id);
        return view('admin.student.student-registraion-fees.edit', compact('student_registraion_fees'));
    }

    public function student_registration_fees_update(Request $request, $id)
    {
        $student_registraion_fees = StudentRegistrationFees::findOrFail($id);
        $student_registraion_fees->update($request->all());
        return redirect()->route('student-registration-fees')->with('success', 'Student registration fees updated successfully');
    }

    public function student_registration_fees_destroy($id)
    {
        if (StudentRegistrationFees::find($id)) {
            StudentRegistrationFees::find($id)->delete();
            return redirect()->route('student-registration-fees')->with('success', 'Student registration fees deleted successfully');
        }
        return redirect()->route('student-registration-fees')->with('error', 'Student registration fees not found');
    }

    // Question
    public function student_question(Request $request)
    {
        if ($request->has('question')) {
            $student_question = StudentApplyQuestions::where('question', 'like', '%' . $request->question . '%')->paginate(12);
        } else {
            $student_question = StudentApplyQuestions::paginate(12);
        }
        return view('admin.student.student-apply-question.index', compact('student_question'));
    }

    public function student_question_create()
    {
        return view('admin.student.student-apply-question.create');
    }

    public function student_question_store(Request $request)
    {
        $request->validate([
            'question' => 'required',
        ]);
        StudentApplyQuestions::create($request->except('_token') + ['user_id' => Auth::user()->id]);
        return redirect()->route('student-question')->with('success', 'Student Apply Question created successfully');
    }

    public function student_question_edit($id)
    {
        $student_question = StudentApplyQuestions::findOrFail($id);
        return view('admin.student.student-apply-question.edit', compact('student_question'));
    }

    public function student_question_update(Request $request, $id)
    {
        $student_question = StudentApplyQuestions::findOrFail($id);
        $student_question->update($request->all());
        return redirect()->route('student-question')->with('success', 'Student Question  updated successfully');
    }

    public function student_question_destroy($id)
    {
        $student_question = StudentApplyQuestions::find($id);
        if ($student_question) {
            $student_question->delete();
            return redirect()->route('student-question')->with('success', 'Student Question deleted successfully');
        } else {
            return redirect()->route('student-question')->with('error', 'Student Question not found');
        }
    }


    //  student assistance
    public function student_assistance(Request $request)
    {
        if ($request->has('title')) {
            $student_assistance = StudentAssistance::where('title', 'like', '%' . $request->title . '%')->paginate(12);
        } else {
            $student_assistance = StudentAssistance::paginate(12);
        }
        return view('admin.student.student-assistance.index', compact('student_assistance'));
    }
    public function student_assistance_create()
    {
        return view('admin.student.student-assistance.create');
    }
    public function student_assistance_store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);
        StudentAssistance::create($request->except('_token'));
        return redirect()->route('student-assistance')->with('success', 'Student Assistance created successfully');
    }
    public function student_assistance_edit($id)
    {
        $student_assistance = StudentAssistance::findOrFail($id);
        return view('admin.student.student-assistance.edit', compact('student_assistance'));
    }
    public function student_assistance_update(Request $request, $id)
    {
        $student_assistance = StudentAssistance::findOrFail($id);
        $student_assistance->update($request->except('_token'));
        return redirect()->route('student-assistance')->with('success', 'Student Assistance  updated successfully');
    }
    public function student_assistance_destroy($id)
    {
        if ($student_assistance = StudentAssistance::find($id)) {
            $student_assistance->delete();
            return redirect()->route('student-assistance')->with('success', 'Student Assistance deleted successfully');
        } else {
            return redirect()->route('student-assistance')->with('error', 'Student Assistance not found');
        }
    }

    //  student guide
    public function student_guide(Request $request)
    {
        if ($request->has('title')) {
            $student_guide = PopularStudentGuide::where('title', 'like', '%' . $request->title . '%')->paginate(12);
        } else {
            $student_guide = PopularStudentGuide::paginate(12);
        }
        return view('admin.student.student-guide.index', compact('student_guide'));
    }
    public function student_guide_create()
    {
        return view('admin.student.student-guide.create');
    }
    public function student_guide_store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'doc_file' => 'mimes:pdf,doc,docx|max:2048',
        ]);
        $data = $request->except('_token');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/imagesapi/');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }
        if ($request->hasFile('doc_url')) {
            $doc_file = $request->file('doc_url');
            $name = time() . '.' . $doc_file->getClientOriginalExtension();
            $destinationPath = public_path('/imagesapi/');
            $doc_file->move($destinationPath, $name);
            $data['doc_url'] = $name;
        }
        PopularStudentGuide::create($data);
        return redirect()->route('student-guide')->with('success', 'Student Guide created successfully');
    }
    public function student_guide_edit($id)
    {
        $studentGuide = PopularStudentGuide::findOrFail($id);
        return view('admin.student.student-guide.edit', compact('studentGuide'));
    }
    public function student_guide_update(Request $request, $id)
    {
        $student_guide = PopularStudentGuide::findOrFail($id);
        $data = $request->except('_token');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/imagesapi/');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        } else {
            $data['image'] = $student_guide->image;
        }
        if ($request->hasFile('doc_url')) {
            $doc_file = $request->file('doc_url');
            $name = time() . '.' . $doc_file->getClientOriginalExtension();
            $destinationPath = public_path('/imagesapi/');
            $doc_file->move($destinationPath, $name);
            $data['doc_url'] = $name;
        } else {
            $data['doc_url'] = $student_guide->doc_url;
        }
        $student_guide->update($data);
        return redirect()->route('student-guide')->with('success', 'Student Guide updated successfully');
    }
    public function student_guide_destroy($id)
    {
        if (PopularStudentGuide::find($id)) {
            $student_guide = PopularStudentGuide::findOrFail($id);
            $student_guide->delete();
            return redirect()->route('student-guide')->with('success', 'Student Guide deleted successfully');
        }
        return redirect()->route('student-guide')->with('error', 'Student Guide not found');
    }






    /**
     * Add an OEL 360 payment ledger entry (the Payments tab's "Add payment" form).
     * "Pay later" only records the amount owed (payments_link, no payments row); every
     * other mode records it as collected (payments_link + a matching payments row), mirroring
     * how Cash/Cheque/Bank entries worked before. University Application Fee is the only
     * service that needs a university + program, since it's tied to a specific application.
     */
    public function payment_link(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'student_id' => ['required'],
            'master_service' => ['required'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'discount' => ['nullable', 'numeric', 'min:0', 'lte:amount'],
            'paymentMode' => ['required', 'in:UPI,Card,Bank transfer,Cash,Pay later'],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Check the fields and try again.', 'errors' => $validator->errors()], 422);
        }

        $student = Student::where('user_id', $request->student_id)->first();
        if (!$student || !$student->email) {
            return response()->json(['status' => false, 'message' => 'Student not found.'], 404);
        }
        $this->authorizePaymentAccess($student);

        $service = MasterService::find($request->master_service);
        if (!$service) {
            return response()->json(['status' => false, 'message' => 'Unknown service.', 'errors' => ['master_service' => ['Unknown service.']]], 422);
        }
        if ($service->name === 'University Application Fee' && (empty($request->selected_university) || empty($request->selected_program))) {
            return response()->json(['status' => false, 'message' => 'University and program are required for this service.', 'errors' => ['selected_program' => ['University and program are required for this service.']]], 422);
        }

        $payLater = $request->paymentMode === 'Pay later';
        $alreadyPaid = $this->paymentLedgerQuery($student->email)
            ->where('payments_link.master_service', $service->id)
            ->where(fn ($query) => $query->whereNull('payments_link.payment_type_remarks')->orWhere('payments_link.payment_type_remarks', '!=', 'applied_program_pay_later'))
            ->exists();
        if (!$payLater && $alreadyPaid) {
            return response()->json(['status' => false, 'message' => $service->name . ' is already paid. Delete the old entry first if this is a correction.'], 422);
        }

        $discount = (float) ($request->discount ?? 0);
        $amount = (float) $request->amount - $discount;

        $controller = new LeadsManageCotroller();
        $data = PaymentsLink::create([
            'token' => $controller->generateToken(),
            'user_id' => $request->student_id,
            'program_id' => $request->selected_program ?: null,
            'selected_university' => $request->selected_university ?: null,
            'master_service' => $service->id,
            'sub_service' => '',
            'discount' => $discount,
            'is_discount' => $discount > 0 ? 1 : 0,
            'email' => $student->email,
            'remarks' => $request->remarks,
            'payment_mode' => $payLater ? null : $request->paymentMode,
            'payment_type_remarks' => $payLater ? 'applied_program_pay_later' : '',
            'amount' => $amount,
            'expired_in' => date('Y-m-d H:i:s', strtotime('+10 days')),
            'fallowp_unique_id' => $controller->uniqidgenrate(),
        ]);

        if (!$payLater) {
            Payment::create([
                'payment_id' => $data->id,
                'payment_method' => $request->paymentMode,
                'fallowp_unique_id' => $data->fallowp_unique_id,
                'customer_name' => trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? '')),
                'user_id' => $request->student_id,
                'customer_email' => $student->email,
                'amount' => $amount,
                'payment_status' => 'success',
                'json_response' => 'null',
            ]);
        }

        return response()->json(['status' => true, 'success' => true, 'message' => 'Payment added.', 'id' => $data->id]);
    }

  


    public function payment_link_details(Request $request)
    {

        $email = Student::where('user_id', $request->student_id)->pluck('email')->first();

        $paymentData = PaymentsLink::with('master_service')->where('email', $email)
            
            ->select('amount', 'email', 'payment_type_remarks', 'master_service', 'remarks', 'id', 'user_id')
            ->whereNotNull('master_service')->get();
          
        $student_course_exit = PaymentsLink::where('email', $email)->pluck('program_id')->toArray();
        
        $program_applied = PaymentsLink::with('program')->select('id', 'user_id', 'email', 'program_id','payment_type_remarks')
            ->where('email', $email)
           
            ->where(function ($query) {
                $query->where('payment_type_remarks', 'applied_program_pay_later')
                    ->orWhere('payment_type_remarks', 'applied_program');
            })
            ->get();
       

        if ($program_applied) {
            $program_applied = $program_applied;
            $program_ids = $program_applied->pluck('program.school_id')->toArray();
            $university = University::whereIn('id', $program_ids)->select('id', 'university_name')->get();
            
        } else {
            $program_applied = NULL;
            $university = NULL;
        }

        
        return response()->json(['payment_data' => $paymentData, 'program_applied' => $program_applied, 'university' => $university]);
    }
    public function delete_payment_link(Request $request)
    {
        $payment = PaymentsLink::find($request->score_id);
        if (!$payment) {
            return response()->json(['success' => false, 'message' => 'Payment entry not found.'], 404);
        }
        if ($student = Student::where('email', $payment->email)->first()) {
            $this->authorizePaymentAccess($student);
        }
        Payment::where('fallowp_unique_id', $payment->fallowp_unique_id)->delete();
        $payment->delete();

        return response()->json(['success' => true, 'message' => 'Payment entry deleted.']);
    }

    public function markPaymentPaid(Request $request)
    {
        $request->validate(['id' => ['required']]);
        $payment = PaymentsLink::find($request->id);
        if (!$payment) {
            return response()->json(['success' => false, 'message' => 'Payment entry not found.'], 404);
        }
        $student = Student::where('email', $payment->email)->first();
        if ($student) {
            $this->authorizePaymentAccess($student);
        }
        if ($payment->payment_type_remarks !== 'applied_program_pay_later') {
            return response()->json(['success' => false, 'message' => 'This entry is already paid.'], 422);
        }
        $payment->payment_type_remarks = '';
        $payment->payment_mode = $payment->payment_mode ?: 'UPI';
        $payment->save();
        Payment::create([
            'payment_id' => $payment->id,
            'payment_method' => $payment->payment_mode,
            'fallowp_unique_id' => $payment->fallowp_unique_id,
            'user_id' => $payment->user_id,
            'customer_email' => $payment->email,
            'amount' => $payment->amount,
            'payment_status' => 'success',
            'json_response' => 'null',
        ]);

        return response()->json(['success' => true, 'message' => 'Marked as paid.']);
    }

    /**
     * Shared ownership gate for the OEL 360 payment ledger (add/mark paid/delete) -
     * same rule as the Payments tab itself: Administrators see everything, agents see
     * their own sub-tree, everyone else only their own students.
     */
    private function authorizePaymentAccess(Student $student): void
    {
        $user = Auth::user();
        abort_unless($user->can('application.view'), 403);
        if ($user->hasRole('Administrator')) {
            return;
        }
        $allowedOwners = [$user->id];
        if ($user->hasRole('agent')) {
            $allowedOwners = User::where('added_by', $user->id)->whereNotIn('admin_type', ['student'])->pluck('id')->all();
            $allowedOwners[] = $user->id;
        }
        abort_unless(in_array($student->added_by, $allowedOwners), 403);
    }


    public function applied_program()
    {

        $student_user = Auth::user();
        
        $student_id = Student::where('user_id', $student_user->id)->select('user_id', 'id')->first();
       
        if (empty($student_id)) {
            abort(404);
        }
        $table_three_sixtee = DB::table('tbl_three_sixtee')->where('sba_id', $student_id->id)->select('application', 'visa_application')->first();
       
        if (isset($table_three_sixtee->application) && $table_three_sixtee->application != 'null' && $table_three_sixtee->visa_application != 'null') {
            
        
            $application = json_decode($table_three_sixtee->application, true);
            
            $visa_application = $table_three_sixtee->visa_application;
            
            $applied_application = [];
            foreach ($application['program_ids'] as $program_id) {
                $status_key = $program_id . '_application_status';
                $remarks_key = 'remarks_' . $program_id;
                if (isset($application[$status_key])) {
                    $applied_application[$program_id] = $application[$status_key];
                }
            }

          
        } else {
            
            
            $applied_application = [];
            $visa_application = null;
        }

            $program_applied = PaymentsLink::with([
                'program:id,name,school_id',
                'program.university_name:id,university_name',
                'payments'
            ])
            ->when(auth()->user()->role == 'student', function ($query) {
                $query->orWhere('payment_type_remarks', 'applied_program_pay_later')
                    ->orWhere('payment_type_remarks', 'applied_program');
            })
            ->where('user_id', $student_id->user_id)
            ->get()
            ->unique('program_id'); // Filter duplicates by program_id at the collection level

            
        return view('admin.student.applied-program', compact('program_applied', 'table_three_sixtee', 'applied_application', 'visa_application'));
    }


    public function delete_program($id)
    {
            if (empty($id)) {
                abort(404);
            }
            $program_applied = PaymentsLink::with([
                'program:id,name,school_id',
                'program.university_name:id,university_name',
                'payments'
            ])
            ->when(auth()->user()->role == 'student', function ($query) {
                $query->orWhere('payment_type_remarks', 'applied_program_pay_later')
                    ->orWhere('payment_type_remarks', 'applied_program');
            })
            ->where('user_id', auth()->user()->id)
            ->find($id);
        if ($program_applied) {
            $program_applied->delete();
        }
        return redirect(url('student/applied-program'));
    }

    public function get_school_attendend(Request $request)
    {
        $user_id = Auth::user()->id;
        $about_student = DB::table('student')->where('user_id', $user_id)->first();
        $school_attendend = StudentAttendence::with('country:name,id', 'province:id,country_id,name', 'student:first_name,last_name,id', 'documents:id,name')->where('student_id', $about_student->id)->get();
        return response()->json(['success' => true, 'school_attendend' => $school_attendend]);
    }

    public function check_school_attendend_store(Request $request)
    {
        $user_id = Auth::user()->id;
        $student_id = DB::table('student')->where('user_id', $user_id)->first();
        $school_attendend = StudentAttendence::where('student_id', $student_id->id)->where('education_level_id', $request->program_level_id)->get();
        if (count($school_attendend) > 0) {
            $success = true;
        } else {
            $success = false;
        }
        return response()->json(['success' => $success]);
    }

    public function check_student_attended(Request $request)
    {
        $document = Documents::where('program_level_id', $request->program_level_id)->count();
        if ($document == $request->checkedCount) {
            $status = True;
        } else {
            $status = false;
        }
        return response()->json(['success' => true, 'status' => $status, 'document' => $document]);
    }

    public function get_student_attendence($id)
    {
        $school_attended = SchoolAttended::where('id', $id)->first();
        return response()->json(['success' => true, 'school_attended' => $school_attended]);
    }

    public function get_student_test_score(Request $request)
    {
        $user_id = Auth::user()->id;
        $student = DB::table('student')->select('id')->where('user_id', $user_id)->first();
        $student_id = $student->id;
        $test_score = DB::table('test_scores')
            ->where('student_id', $student_id)
            ->get()
            ->merge(DB::table('additional_qualification')
                ->where('student_id', $student_id)
                ->get());
        return response()->json(['success' => true, 'test_score' => $test_score]);
    }

    public function fetch_payment_details(Request $request)
    {
       
        $uniqueId = PaymentsLink::where('user_id', $request->student_id)->where('id', $request->payment_id)->pluck('fallowp_unique_id')->first();
        $about_payment = Payment::with('PaymentLink', 'PaymentLink.program:name,id', 'PaymentLink.master_service')->where('fallowp_unique_id', $uniqueId)->with('PaymentLink')->select('payment_status', 'user_id', 'amount', 'customer_email', 'fallowp_unique_id')->get();

        return response()->json(['success' => true, 'about_payment' => $about_payment]);
    }


    public function get_program(Request $request)
    {             
        $program_appliedd = PaymentsLink::with('program')->select('id', 'user_id', 'email', 'program_id','payment_type_remarks')
                            ->where('user_id', $request->student_id)
                            ->where('selected_university', $request->selectedUniversityId)          
                            ->where(function ($query) {
                                $query->where('payment_type_remarks', 'applied_program_pay_later')
                                    ->orWhere('payment_type_remarks', 'applied_program');
                            })
                            ->get();
        return response()->json(['program_appliedd' => $program_appliedd]);
    }
}
