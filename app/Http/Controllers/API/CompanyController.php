<?php

namespace App\Http\Controllers\API;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends MainController
{
    public function create(Request $request)
    {

        $validate_company = Validator::make($request->all(), [
            'code'  => 'required|string|max:100|unique:companies,company_code',
            'name'  => 'required|string',
        ]);

        if ($validate_company->fails()) {
            return $this->responseError('Failed Create Company', $validate_company->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $company = new Company();
            $company->company_code = strtoupper(trim($request->code));
            $company->company_name = ucwords(trim($request->name));
            $company->save();

            return $this->responseSuccess($company);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function read($id = null)
    {
        try {
            if (is_null($id)) {
                $result = Company::orderByDesc('company_id')->paginate();
            } else {
                $result = Company::where('company_id', $id)->firstOrFail();
            }
            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        if (is_null($request->id)) {
            throw new \Exception("Param Company ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validate_company = Validator::make($request->all(), [
            'code'  => 'required|string|unique:companies,company_code,' . $request->id . ',company_id'
        ]);

        if ($validate_company->fails()) {
            return $this->responseError('Failed Update', $validate_company->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $company = Company::where('company_id', (int)$request->id)->firstOrFail();

            $company->company_code = $request->code;
            $company->company_name = $request->name;
            $company->save();

            return $this->responseSuccess($company);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
