<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Traits\IssueTokenTrait;
use App\Traits\PermissionTrait;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use PermissionTrait, IssueTokenTrait, ResponseJsonTrait;

    public function signin(Request $request)
    {
        $account = null;

        try {

            $validator = Validator::make($request->all(), [
                'email'     => 'required|string|email',
                'password'  => 'required|string|min:8'
            ]);

            $credentials = request(['email', 'password']);


            if ($validator->fails()) {
                return $this->responseError('Failed Login.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            } else {

                $user = User::with('role')->where("email", $request->email)->firstOrFail();

                if (!$user->email_verified_at) {
                    return $this->responseError('Your email has not been verified', $request->email, Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                $account["user_id"] = $user->user_id;
                $account["user_email"] = $user->email;
                $account["user_last_login_at"] = $user->last_login_at;
                $account["user_role_id"] = $user->role ? $user->role->role_id : null;
                $account["user_role_name"] = $user->role ? $user->role->role_name : null;
                $account["user_role_display_name"] = $user->role ? $user->role->role_display_name : null;
                $account["user_role_description"] = $user->role ? $user->role->role_description : null;

                if ($user->fk_role_id == 1) {
                    $account["module_access"] = "Get All Access";
                } else if ($user->fk_role_id == 2) {

                    $employee = Employee::with('branch', 'department.company', 'job_title', 'job_type')->where('fk_user_id', $user->user_id)->first();

                    if ($employee) {

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

                        $account["module_access"] = $this->HasPermission($employee);
                    }
                }

                $token = $this->createToken($account, $credentials);

                if (!$token) {
                    return $this->responseError('Failed Signin, Invalid Email or Password', '', Response::HTTP_UNAUTHORIZED);
                }

                $user->last_login_at = date("Y-m-d H:i:s");
                $user->save();

                return $this->responseSuccess($token);
            }
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), $e->getTraceAsString(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function signout()
    {
        auth()->logout(true);
        return $this->responseSuccess('Successfully logged out');
    }

    public function verify($token)
    {
        $status = "";
        try {
            $user = User::where('activation_token', $token)->first();
            if (isset($user)) {
                $user->email_verified_at = date('Y-m-d H:i:s');
                $user->save();
                $status = "Your email has been verified.";
            } else {
                $status = "Your Activation Token cannot be identified.";
            }
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 500);
        }
        return $this->responseSuccess($status);
    }

    public function refresh(Request $request)
    {
        try {
            $token = $this->refreshToken();

            if (!$token) {
                return $this->responseError('Failed Refresh Token, Invalid Email or Password', '', Response::HTTP_UNAUTHORIZED);
            }

            return $this->responseSuccess($token);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
