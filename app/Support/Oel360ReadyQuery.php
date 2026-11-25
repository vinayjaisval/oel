<?php

namespace App\Support;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Oel360ReadyQuery
{
    /** The same eligibility and role scope used by the legacy OEL 360 list. */
    public static function forUser($user, ?Request $request = null)
    {
        $query = Student::query();

        if ($user->hasRole('agent')) {
            $query->where(function ($query) use ($user) {
                $query->where('student.added_by_agent_id', $user->id)
                    ->orWhere('student.added_by', $user->id);
            });
        }
        if ($user->hasRole('sub_agent')) {
            $query->where('student.added_by', $user->id);
        }

        if ($request) {
            if ($request->filled('q')) {
                $term = '%' . $request->input('q') . '%';
                $query->where(function ($q) use ($term) {
                    $q->where('student.first_name', 'like', $term)
                        ->orWhere('student.last_name', 'like', $term)
                        ->orWhere('student.email', 'like', $term)
                        ->orWhere('student.phone_number', 'like', $term);
                });
            }
            if ($request->first_name) {
                $query->where('student.first_name', 'like', '%' . $request->first_name . '%');
            }
            if ($request->email) {
                $query->where('student.email', 'like', '%' . $request->email . '%');
            }
            if ($request->subagent_id) {
                $query->where('student.added_by', $request->subagent_id);
            }
            if ($request->agent_id) {
                $query->where('student.added_by_agent_id', $request->agent_id);
            }
        }

        $query->join('users', 'users.id', '=', 'student.added_by')
            ->join(DB::raw('(SELECT MAX(id) as id, student_user_id FROM student_by_agent GROUP BY student_user_id) as sba_latest'), function ($join) {
                $join->on('sba_latest.student_user_id', '=', 'student.user_id');
            })
            ->join('student_by_agent', 'student_by_agent.id', '=', 'sba_latest.id')
            ->leftJoin('payments', 'payments.customer_email', '=', 'student.email')
            ->leftJoin('payments_link', 'payments_link.fallowp_unique_id', '=', 'payments.fallowp_unique_id')
            ->where('student.status_threesixty', 1)
            ->where('student.profile_complete', 1);

        if ($user->hasRole('visa')) {
            $query->join('tbl_three_sixtee', 'tbl_three_sixtee.sba_id', '=', 'student.id')
                ->where('tbl_three_sixtee.visa_application', 'Accepted');
        }
        if ($user->hasRole('Application Punching')) {
            $query->join('tbl_three_sixtee', 'tbl_three_sixtee.sba_id', '=', 'student.id')
                ->where('tbl_three_sixtee.application_punching', 1);
        }

        return $query;
    }
}
