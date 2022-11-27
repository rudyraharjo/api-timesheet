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

class EmployeeController extends MainController
{
    use PermissionTrait;

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'nik'  => 'required|string',
            'branch_id'     => 'required',
            'fullname'      => 'required',
            'job_title_id'  => 'required',
            'job_type_id'   => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseError('Failed Create Employee', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        DB::beginTransaction();
        try {

            if (Employee::CompanyId($this->company_id)->where([
                ['employee_nik', trim($request->nik)]
            ])->count() == 0) {
                $emp = (object) ['image' => ""];

                if ($request->hasFile('employee_avatar')) {
                    $original_filename = $request->file('employee_avatar')->getClientOriginalName();
                    $original_filename_arr = explode('.', $original_filename);

                    $file_ext = end($original_filename_arr);
                    $destination_path = './avatar/';
                    $image = 'E-' . $this->company_id . '-' . time() . '.' . $file_ext;

                    if ($request->file('employee_avatar')->move($destination_path, $image)) {
                        $emp->image = '/avatar/' . $image;
                    }
                }

                if ($request->account_email > 0) {

                    $validator_acc = Validator::make($request->all(), [
                        'account_email'     => 'required|string|email',
                        'account_password'  => 'required|string|min:8'
                    ]);

                    if ($validator_acc->fails()) {
                        return $this->responseError('Failed Create Account', $validator_acc->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
                    }

                    $user = new User();
                    $user->fk_role_id = 2;
                    $user->email = $request->account_email;
                    $user->password = app('hash')->make($request->account_password);
                    $user->activation_token = sha1(time());
                    $user->save();
                }

                $addEmp = new Employee();
                $addEmp->fk_user_id = $user ? $user->user_id : null;
                $addEmp->fk_branch_id = (int)$request->branch_id;
                $addEmp->fk_department_id = (int)$request->department_id;
                $addEmp->fk_job_title_id = (int)$request->job_title_id;
                $addEmp->fk_job_type_id = (int)$request->job_type_id;
                $addEmp->employee_nik = trim($request->nik);
                $addEmp->employee_fullname = ucwords(trim($request->fullname));
                $addEmp->employee_avatar = $emp->image ? url($emp->image) : null;
                $addEmp->employee_birth_place = ucwords(trim($request->birth_place));
                $addEmp->employee_birth_date = date('Y-m-d', strtotime($request->birth_date));
                $addEmp->employee_marital_status = trim($request->marital_status);
                $addEmp->employee_gender = trim($request->gender);
                $addEmp->employee_join_date = date('Y-m-d', strtotime($request->join_date));

                $addEmp->save();

                DB::commit();
                $employee = Employee::with('user', 'branch', 'department', 'job_title', 'job_type')->where('employee_id', $addEmp->employee_id)->first();

                return $this->responseSuccess($employee, "Success Create Employee", Response::HTTP_CREATED);
            } else {
                $data["nik"][] = "Employee Nik '" . strtoupper(trim($request->nik)) . "' is already in use";
                return $this->responseError('Failed Create Employee', $data, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function read($id = null)
    {
        try {
            if (is_null($id)) {
                $result = Employee::CompanyId($this->company_id)->with('branch', 'department', 'job_title', 'job_type')->orderByDesc('employee_id')->paginate();
            } else {
                $result = Employee::CompanyId($this->company_id)->with('branch', 'department', 'job_title', 'job_type')->where('employee_id', $id)->firstOrFail();
            }
            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        if (is_null($request->id)) {
            throw new \Exception("Param Employee ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validator = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'nik'           => 'required|string',
            'branch_id'     => 'required',
            'fullname'      => 'required',
            'job_title_id'  => 'required',
            'job_type_id'   => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseError('Failed Update Employee', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $update = Employee::CompanyId($this->company_id)->where([
                ['employee_id', (int)$request->id]
            ])->firstOrFail();

            // dd(url($update->employee_avatar));
            $emp = (object) ['image' => $update->employee_avatar];

            if ($request->hasFile('employee_avatar')) {
                $original_filename = $request->file('employee_avatar')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);

                $file_ext = end($original_filename_arr);
                $destination_path = './avatar/';
                $image = 'E-' . $this->company_id . '-' . time() . '.' . $file_ext;

                if ($request->file('employee_avatar')->move($destination_path, $image)) {
                    $emp->image = '/avatar/' . $image;
                }
            }

            $checkNik = Employee::CompanyId($this->company_id)->where([
                ['employee_nik', trim($request->nik)],
                ['employee_id', '<>', (int)$request->id],
            ])->count();

            if ($checkNik == 0) {
                $update->fk_branch_id = (int)$request->branch_id;
                $update->fk_department_id = (int)$request->department_id;
                $update->fk_job_title_id = (int)$request->job_title_id;
                $update->fk_job_type_id = (int)$request->job_type_id;
                $update->employee_nik = trim($request->nik);
                $update->employee_fullname = ucwords(trim($request->fullname));
                $update->employee_avatar = $emp->image ? url($emp->image) : null;
                $update->employee_birth_place = ucwords(trim($request->birth_place));
                $update->employee_birth_date = date('Y-m-d', strtotime($request->birth_date));
                $update->employee_marital_status = trim($request->marital_status);
                $update->employee_gender = trim($request->gender);
                $update->employee_join_date = date('Y-m-d', strtotime($request->join_date));

                $update->save();

                $employee = Employee::with('user', 'branch', 'department', 'job_title', 'job_type')->where('employee_id', $update->employee_id)->first();

                return $this->responseSuccess($employee, "Success Update Employee", Response::HTTP_CREATED);
            } else {
                $data["nik"][] = "Employee Nik '" . strtoupper(trim($request->nik)) . "' is already in use";
                return $this->responseError('Failed Create Employee', $data, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'id'            => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseError('Failed Delete Employee', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            if ($emp = Employee::CompanyId($this->company_id)->where([
                ['employee_id', (int)$request->id]
            ])->first()) {
                if (User::where([
                    ['user_id', (int)$emp->fk_user_id]
                ])->count() > 0) {
                    User::where([
                        ['user_id', (int)$emp->fk_user_id]
                    ])->delete();
                }
                Employee::CompanyId($this->company_id)->where([
                    ['employee_id', (int)$request->id]
                ])->delete();
            } else {
                throw new \Exception("Employee ID " . $request->id . " Not Found", Response::HTTP_BAD_REQUEST);
            }

            return $this->responseSuccess("Success Delete Employee ID " . (int)$request->id);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", $e->getCode());
        }
    }

    public function trashed()
    {
        try {
            $employee = Employee::onlyTrashed()->get();
            return $this->responseSuccess($employee);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
