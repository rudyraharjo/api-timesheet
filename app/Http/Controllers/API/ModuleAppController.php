<?php

namespace App\Http\Controllers\API;

use App\Models\ModuleApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class ModuleAppController extends MainController
{
    public function create(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'name'          => 'required|string|max:40',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Create Module App', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            if (ModuleApp::CompanyId($this->company_id)->where([
                ['module_app_name', strtolower(trim($request->name))]
            ])->count() == 0) {

                $moduleApp = new ModuleApp();
                $moduleApp->fk_company_id = $this->company_id;
                $moduleApp->module_app_name = strtolower(trim($request->name));
                $moduleApp->module_app_description = ucwords(trim($request->description));

                $moduleApp->save();

                return $this->responseSuccess($moduleApp);
            } else {
                $data["name"][] = "Module Name is already in use";
                return $this->responseError('Failed Create Module App', $data, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function read($id = null)
    {
        try {
            if (is_null($id)) {
                $result = ModuleApp::CompanyId($this->company_id)->orderByDesc('module_app_id')->paginate();
            } else {
                $result = ModuleApp::CompanyId($this->company_id)->where('module_app_id', $id)->firstOrFail();
            }
            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        if (is_null($request->id)) {
            throw new \Exception("Param Module App ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validate = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'name'          => 'required|string|max:40',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Update', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $moduleApp = ModuleApp::CompanyId($this->company_id)->where([
                ['module_app_id', (int)$request->id],
            ])->firstOrFail();

            $moduleApp->fk_company_id = $this->company_id;
            $moduleApp->module_app_name = strtolower(trim($request->name));
            $moduleApp->module_app_description = ucwords(trim($request->description));

            $moduleApp->save();
            return $this->responseSuccess($moduleApp);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Request $request)
    {
        try {
            if (is_null($request->id)) {
                throw new \Exception("Param Module App ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (ModuleApp::CompanyId($this->company_id)->where([
                ['module_app_id', (int)$request->id]
            ])->first()) {
                ModuleApp::CompanyId($this->company_id)->where([
                    ['module_app_id', (int)$request->id]
                ])->delete();
            } else {
                throw new \Exception("Module ID " . $request->id . " Not Found", Response::HTTP_BAD_REQUEST);
            }

            return $this->responseSuccess("Success Delete Module ID " . (int)$request->id);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", $e->getCode());
        }
    }
}
