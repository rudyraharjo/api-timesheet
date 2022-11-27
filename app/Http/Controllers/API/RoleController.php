<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends MainController
{
    public function create(Request $request)
    {

        $validate_role = Validator::make($request->all(), [
            'name'  => 'required|string|max:20|unique:roles,role_name',
            'display_name'  => 'required|max:200|string',
        ]);

        if ($validate_role->fails()) {
            return $this->responseError('Failed Create Role', $validate_role->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $role = new Role();
            $role->role_name = strtoupper(trim($request->name));
            $role->role_display_name = ucwords(trim($request->display_name));
            $role->role_description = ucwords(trim($request->description));

            $role->save();

            return $this->responseSuccess($role);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function read($id = null)
    {
        try {
            if (is_null($id)) {
                $result = Role::orderByDesc('role_id')->paginate();
            } else {
                $result = Role::where('role_id', $id)->firstOrFail();
            }
            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        if (is_null($request->id)) {
            throw new \Exception("Param Role ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validate_role = Validator::make($request->all(), [
            'name'  => 'required|string|unique:roles,role_name,' . $request->id . ',role_id'
        ]);

        if ($validate_role->fails()) {
            return $this->responseError('Failed Update', $validate_role->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $role = Role::where('role_id', (int)$request->id)->firstOrFail();

            $role->role_name = $request->name;
            $role->role_display_name = $request->display_name;
            $role->role_description = $request->description;
            $role->save();

            return $this->responseSuccess($role);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Request $request)
    {
        try {
            if (is_null($request->id)) {
                throw new \Exception("Param Role ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (Role::where('role_id', (int)$request->id)->first()) {
                Role::where('role_id', $request->id)->delete();
            } else {
                throw new \Exception("Role ID " . $request->id . " Not Found", Response::HTTP_BAD_REQUEST);
            }
            return $this->responseSuccess("Success Delete Role ID " . (int)$request->id);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", $e->getCode());
        }
    }
}
