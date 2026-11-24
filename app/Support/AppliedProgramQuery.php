<?php

namespace App\Support;

use App\Models\PaymentsLink;
use Illuminate\Support\Facades\DB;

/** Shared definition of a row in the applied-program list. */
class AppliedProgramQuery
{
    public static function forStudents($studentUserIds)
    {
        return PaymentsLink::query()
            ->with(['program.university_name', 'payments'])
            ->join('users', 'users.id', '=', 'payments_link.user_id')
            ->leftJoin('payments', 'payments.fallowp_unique_id', '=', 'payments_link.fallowp_unique_id')
            ->join(DB::raw('(SELECT MAX(id) as id, email FROM student_by_agent GROUP BY email) as latest_sba'), 'latest_sba.email', '=', 'payments_link.email')
            ->join('student_by_agent', 'student_by_agent.id', '=', 'latest_sba.id')
            ->whereIn('payments_link.user_id', $studentUserIds)
            ->whereIn('payments_link.payment_type_remarks', ['applied_program', 'applied_program_pay_later'])
            ->select(
                'payments_link.program_id', 'payments_link.user_id',
                DB::raw('MAX(payments_link.id) as id'),
                DB::raw('MAX(users.name) as name'),
                DB::raw('MAX(users.email) as user_email'),
                DB::raw('MAX(payments_link.email) as email'),
                DB::raw('MAX(payments_link.payment_type) as payment_type'),
                DB::raw('MAX(payments_link.payment_type_remarks) as payment_type_remarks'),
                DB::raw('MAX(payments_link.payment_date) as payment_date'),
                DB::raw('MAX(payments_link.app_id) as app_id'),
                DB::raw('MAX(payments_link.status) as status'),
                DB::raw('MAX(payments_link.fallowp_unique_id) as fallowp_unique_id'),
                DB::raw('MAX(payments_link.created_at) as created_at'),
                DB::raw('MAX(student_by_agent.assigned_to) as assigned_to'),
                DB::raw('MAX(student_by_agent.added_by_agent_id) as added_by_agent_id'),
                DB::raw('MAX(payments.id) as payment_id'),
                DB::raw('MAX(payments.amount) as payment_amount'),
                DB::raw('MAX(payments.payment_status) as payment_status')
            )
            ->groupBy('payments_link.program_id', 'payments_link.user_id');
    }

    public static function countForStudents($studentUserIds): int
    {
        return DB::query()->fromSub(self::forStudents($studentUserIds)->toBase(), 'applied_program_rows')->count();
    }
}
