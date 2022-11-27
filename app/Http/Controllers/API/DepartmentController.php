<?php

namespace App\Http\Controllers\API;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends MainController
{
    public function create(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'code'          => 'required|string|max:100',
            'name'          => 'required|string',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Create Department', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            if (Department::CompanyId($this->company_id)->where([
                ['department_code', strtoupper(trim($request->code))]
            ])->count() == 0) {

                $add = new Department();
                $add->fk_company_id = $this->company_id;
                $add->department_code = strtoupper(trim($request->code));
                $add->department_name = ucwords(trim($request->name));

                $add->save();

                return $this->responseSuccess($add, "Success Create Department", Response::HTTP_CREATED);
            } else {
                $data["code"][] = "Department Code '" . strtoupper(trim($request->code)) . "' is already in use";
                return $this->responseError('Failed Create Department', $data, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function read($id = null)
    {
        try {
            if (is_null($id)) {
                $result = Department::CompanyId($this->company_id)->orderByDesc('department_id')->paginate();
            } else {
                $result = Department::CompanyId($this->company_id)->where('department_id', $id)->firstOrFail();
            }
            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        if (is_null($request->id)) {
            throw new \Exception("Param Department ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validate = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'code'          => 'required|string|max:40',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Update', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $update = Department::CompanyId($this->company_id)->where([
                ['department_id', (int)$request->id],
            ])->firstOrFail();

            $update->fk_company_id = $this->company_id;
            $update->department_code = strtoupper(trim($request->code));
            $update->department_name = ucwords(trim($request->name));
            $update->save();
            return $this->responseSuccess($update);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Request $request)
    {
        try {

            if (is_null($request->id)) {
                throw new \Exception("Param Department ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (Department::CompanyId($this->company_id)->where([
                ['department_id', (int)$request->id]
            ])->first()) {
                Department::CompanyId($this->company_id)->where([
                    ['department_id', (int)$request->id]
                ])->delete();
            } else {
                throw new \Exception("Department ID " . $request->id . " Not Found", Response::HTTP_BAD_REQUEST);
            }

            return $this->responseSuccess("Success Delete Department ID " . (int)$request->id);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", $e->getCode());
        }
    }
}
