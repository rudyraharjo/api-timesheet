<?php

namespace App\Http\Controllers\API;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PermissionController extends MainController
{
    public function create(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'name'  => 'required|string|max:100',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Create Permission', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            if (Permission::CompanyId()->where([
                ['permission_slug', strtolower(trim(Str::slug($request->name, '-')))]
            ])->count() == 0) {

                $permission = new Permission();
                $permission->fk_company_id = $request->company_id ? (int)$request->company_id : (int)$this->company_id;
                $permission->permission_slug = strtolower(trim(Str::slug($request->name, '-')));
                $permission->permission_name = ucwords(trim($request->name));

                $permission->save();

                return $this->responseSuccess($permission);
            } else {
                $data["name"][] = "Permission Name is already in use";
                return $this->responseError('Failed Create Permission', $data, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function read($id = null)
    {
        try {
            if (is_null($id)) {
                $result = Permission::CompanyId()->orderByDesc('permission_id')->paginate();
            } else {
                $result = Permission::CompanyId()->where('permission_id', $id)->firstOrFail();
            }
            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        if (is_null($request->id)) {
            throw new \Exception("Param Permission ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validate = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'name'  => 'required|string|max:40',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Update', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $permission = Permission::CompanyId()->where([
                ['permission_id', (int)$request->id],
            ])->firstOrFail();

            $permission->fk_company_id = $request->company_id ? (int)$request->company_id : (int)$this->company_id;
            $permission->permission_slug = strtolower(trim(Str::slug($request->name, '-')));
            $permission->permission_name = ucwords(trim($request->name));

            $permission->save();

            return $this->responseSuccess($permission);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Request $request)
    {
        try {
            if (is_null($request->id)) {
                throw new \Exception("Param Permission ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (Permission::CompanyId()->where([
                ['permission_id', (int)$request->id]
            ])->first()) {
                Permission::CompanyId()->where([
                    ['permission_id', (int)$request->id]
                ])->delete();
            } else {
                throw new \Exception("Permission ID " . $request->id . " Not Found", Response::HTTP_BAD_REQUEST);
            }
            return $this->responseSuccess("Success Delete Permission ID " . (int)$request->id);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", $e->getCode());
        }
    }
}
