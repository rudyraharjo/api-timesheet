<?php

namespace App\Traits;

use App\Models\Employee;
use App\Models\ModuleApp;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

trait PermissionTrait
{
    public function CheckPermission($module, $permission)
    {
        $employee = Employee::where('fk_user_id', auth()->user()->user_id)->first();

        if ($employee->fk_department_id || $employee->fk_job_title_id) {

            $module_app_id = ModuleApp::where('module_app_slug', $module)->first()->module_app_id;
            $permission_id = Permission::where('permission_slug', $permission)->first()->permission_id;
            // permission = jobtitle


            $check = DB::table('permission_users')
                ->where('module_app_id', $module_app_id)
                ->where('permission_id', $permission_id)
                ->where(function ($query) use ($employee) {
                    $query->Where('param', '=', 'department_id')
                        ->Where('value', '=', $employee->fk_department_id)
                        ->orWhere('param', '=', 'job_title_id')
                        ->Where('value', '=', $employee->fk_job_title_id);
                })
                ->count();

            if ($check) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function HasPermission($employee)
    {

        $temp_modules = array();
        if ($employee->fk_department_id || $employee->fk_job_title_id) {

            $HasPermission = DB::table('permission_users as pu')
                ->leftJoin('module_apps as ma', 'ma.module_app_id', '=', 'pu.module_app_id')
                ->leftJoin('permissions as p', 'p.permission_id', '=', 'pu.permission_id')
                ->select('ma.module_app_id', 'ma.module_app_slug as module_slug', 'ma.module_app_name as module_name', 'p.permission_slug', 'p.permission_name')
                ->where(function ($query) use ($employee) {
                    $query->Where('pu.param', '=', 'department_id')
                        ->Where('pu.value', '=', $employee->fk_department_id)
                        ->orWhere('pu.param', '=', 'job_title_id')
                        ->Where('pu.value', '=', $employee->fk_job_title_id);
                })
                ->get();

            if (count($HasPermission) > 0) {

                foreach ($HasPermission as $module) {
                    $temp_modules[$module->module_slug] = array(
                        'module_app_id'      => $module->module_app_id,
                        'module_app_slug'    => $module->module_slug,
                        'module_app_name'    => $module->module_name
                    );
                }

                if (count($temp_modules) > 0) {
                    foreach ($temp_modules as $key => $m) {
                        foreach ($HasPermission as $perm) {
                            if ($key == $perm->module_slug) {
                                $temp_modules[$key]["permission"][] = $perm->permission_slug;
                            }
                        }
                    }
                }
            }

            $modules = array_values($temp_modules);
            return $modules;
        }
    }
}
