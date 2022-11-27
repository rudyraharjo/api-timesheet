<?php

namespace App\Http\Controllers\API;

use App\Models\Branch;
use App\Traits\IssueTokenTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class BranchController extends MainController
{
    use IssueTokenTrait;

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'code'          => 'required|string|max:20',
            'name'          => 'required|max:200|string',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Create Branch', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            if (Branch::CompanyId($this->company_id)->where([
                ['branch_code', strtoupper(trim($request->code))]
            ])->count() == 0) {
                $branch = new Branch();
                $branch->fk_company_id = $this->company_id;
                $branch->branch_code = strtoupper(trim($request->code));
                $branch->branch_name = ucwords(trim($request->name));
                $branch->branch_level = ucwords(trim($request->level));

                $branch->save();

                return $this->responseSuccess($branch);
            } else {
                $data["code"][] = "Branch Code '" . strtoupper(trim($request->code)) . "' is already in use";
                return $this->responseError('Failed Create Branch', $data, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function read($id = null)
    {
        try {
            if (is_null($id)) {
                $result = Branch::CompanyId($this->company_id)->orderByDesc('branch_id')->paginate();
            } else {
                $result = Branch::CompanyId($this->company_id)->where('branch_id', $id)->firstOrFail();
            }
            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        if (is_null($request->id)) {
            throw new \Exception("Param Branch ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validate_branch = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'code'          => 'required|string|max:20',
            'name'          => 'required|max:200|string',
        ]);

        if ($validate_branch->fails()) {
            return $this->responseError('Failed Update', $validate_branch->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $branch = Branch::CompanyId($this->company_id)->where([
                ['branch_id', (int)$request->id],
            ])->firstOrFail();

            $branch->fk_company_id = $this->company_id;
            $branch->branch_code = strtoupper(trim($request->code));
            $branch->branch_name = ucwords(trim($request->name));
            $branch->branch_level = ucwords(trim($request->level));

            $branch->save();

            return $this->responseSuccess($branch);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Request $request)
    {
        try {
            if (is_null($request->id)) {
                throw new \Exception("Param Branch ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (Branch::CompanyId($this->company_id)->where([
                ['branch_id', (int)$request->id],
            ])->first()) {
                Branch::CompanyId($this->company_id)->where([
                    ['branch_id', (int)$request->id]
                ])->delete();
            } else {
                throw new \Exception("Branch ID " . $request->id . " Not Found", Response::HTTP_BAD_REQUEST);
            }
            return $this->responseSuccess("Success Delete Branch ID " . (int)$request->id);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", $e->getCode());
        }
    }
}
