<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait UserCompanyTrait
{
    public function CheckUserHasCompany($company_id, $user_id)
    {
        $employeeCompany = DB::table('employees as e')
            ->leftjoin('departments as d', 'd.department_id', '=', 'e.fk_department_id')
            ->leftjoin('companies as c', 'c.company_id', '=', 'd.fk_company_id')
            ->where([
                ['e.fk_user_id', $user_id],
                ['c.company_id', $company_id]
            ])
            ->count();
        if ($employeeCompany > 0) {
            return true;
        } else {
            return false;
        }
    }
}
