<?php

namespace App\Http\Controllers\API;

use App\Models\Employee;
use App\Models\User;
use App\Traits\PermissionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UserController extends MainController
{
    use PermissionTrait;

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email'     => 'required|string|email|max:100|unique:users',
            'password'  => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Failed Registration', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        DB::beginTransaction();
        try {
            $user = new User();
            $user->fk_role_id = $request->role_id;
            $user->email = $request->email;
            $user->password = app('hash')->make($request->password);
            $user->activation_token = sha1(time());
            $user->save();

            if (count($request->employee) > 0) {

                $validator_employee = Validator::make($request->all(), [
                    'employee.nik'  => 'required|string|unique:employees,employee_nik',
                ]);

                if ($validator_employee->fails()) {
                    return $this->responseError('Failed Registration', $validator_employee->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                $employee = new Employee();
                $employee->fk_user_id = $user->user_id;
                $employee->fk_branch_id = $request->employee['branch_id'];
                $employee->employee_nik = $request->employee['nik'];
                $employee->employee_fullname = $request->employee['fullname'];
                $employee->save();
            }

            DB::commit();

            $userEmployee = User::with('employee', 'employee.branch')->where('user_id', $user->user_id)->first();

            return $this->responseSuccess($userEmployee);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function read($id = null)
    {
        try {
            if (is_null($id)) {
                $result = User::with('employee', 'employee.branch')->orderByDesc('user_id')->paginate();
            } else {
                $result = User::with('employee', 'employee.branch')->where('user_id', $id)->firstOrFail();
            }
            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        if (is_null($request->id)) {
            throw new \Exception("Param ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validator_user = Validator::make($request->all(), [
            'email'     => 'required|string|unique:users,email,' . $request->id . ',user_id'
        ]);

        if ($validator_user->fails()) {
            return $this->responseError('Failed Update', $validator_user->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $user = User::where('user_id', (int)$request->id)->firstOrFail();

            $user->email = $request->email;
            $user->password = app('hash')->make($request->password);
            $user->save();

            return $this->responseSuccess($user);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Request $request)
    {
        // Soft Delete
        try {
            if (is_null($request->id)) {
                throw new \Exception("Param User ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (User::where('user_id', (int)$request->id)->first()) {
                User::where('user_id', $request->id)->delete();
            } else {
                throw new \Exception("ID user " . $request->id . " Not Found", Response::HTTP_BAD_REQUEST);
            }
            return $this->responseSuccess("Success Delete ID User " . (int)$request->id);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", $e->getCode());
        }
    }

    public function trashed()
    {
        try {
            $user = User::onlyTrashed()->get();
            return $this->responseSuccess($user);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function profile()
    {

        try {
            $user = User::with('role')->where("user_id", auth()->user()->user_id)->firstOrFail();

            $account["user_id"] = $user->user_id;
            $account["user_email"] = $user->email;
            $account["user_last_login_at"] = $user->last_login_at;
            $account["user_role_id"] = $user->role ? $user->role->role_id : null;
            $account["user_role_name"] = $user->role ? $user->role->role_name : null;
            $account["user_role_display_name"] = $user->role ? $user->role->role_display_name : null;
            $account["user_role_description"] = $user->role ? $user->role->role_description : null;

            if ($user->fk_role_id == 1) {
                $account["module_access"] = "Gell ALL Access";
            } else if ($user->fk_role_id == 2) {
                $employee = Employee::with('branch', 'department.company', 'job_title', 'job_type')->where('fk_user_id', $user->user_id)->first();
                
                if ($employee) {
                    $module_access = $this->HasPermission($employee);
                    $account["employee_branch_id"] = $employee->fk_branch_id;
                    $account["employee_department_id"] = $employee->fk_department_id;
                    $account["employee_id"] = $employee->employee_id;
                    $account["employee_nik"] = $employee->employee_nik;
                    $account["employee_fullname"] = $employee->employee_fullname;
                    $account["employee_avatar"] = $employee->employee_avatar;
                    $account["employee_birth_place"] = $employee->employee_birth_place;
                    $account["employee_marital_status"] = $employee->employee_marital_status;
                    $account["employee_gender"] = $employee->employee_gender;
                    $account["employee_join_date"] = $employee->employee_join_date;

                    if ($employee->department) {
                        if ($employee->department->company) {
                            $account["employee_company_id"] = $employee->department->company->company_id;
                            $account["employee_company_code"] = $employee->department->company->company_code;
                            $account["employee_company_name"] = $employee->department->company->company_name;
                        }
                    }

                    $account["employee_branch"] = $employee->branch ? $employee->branch->branch_code : null;
                    $account["employee_branch_name"] = $employee->branch ? $employee->branch->branch_name : null;
                    $account["employee_branch_level"] = $employee->branch ? $employee->branch->branch_level : null;
                    $account["employee_department_code"] = $employee->department ? $employee->department->department_code : null;
                    $account["employee_job_title_name"] = $employee->job_title ? $employee->job_title->job_title_name : null;
                    $account["employee_job_type_code"] = $employee->job_type ? $employee->job_type->job_type_code : null;
                    $account["employee_job_type_name"] = $employee->job_type ? $employee->job_type->job_type_name : null;
                    $account["employee_job_type_description"] = $employee->job_type ? $employee->job_type->job_type_description : null;

                    $account["module_access"] = $module_access;
                }
            }

            return $this->responseSuccess($account);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
