<?php

namespace App\Http\Controllers\API;

use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class JobTypeController extends MainController
{
    public function create(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'company_id'    => 'required',
            'code'          => 'required|string',
            'name'          => 'required|string',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Create Job Type', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            if (JobType::where([
                ['fk_company_id', (int)$request->company_id],
                ['job_type_code', $request->code]
            ])->count() == 0) {

                $add = new JobType();
                $add->fk_company_id = (int)$request->company_id;
                $add->job_type_code = strtoupper(trim($request->code));
                $add->job_type_name = ucwords(trim($request->name));
                $add->job_type_description = ucwords(trim($request->description));
                $add->save();

                return $this->responseSuccess($add);
            } else {
                $data["name"][] = "Job Type '" . strtoupper(trim($request->code)) . "' is already in use";
                return $this->responseError('Failed Create Job Type', $data, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function read($id = null)
    {
        try {
            if (is_null($id)) {
                $result = JobType::orderByDesc('job_type_id')->paginate();
            } else {
                $result = JobType::where('job_type_id', $id)->firstOrFail();
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

        $validate = Validator::make($request->all(), [
            'company_id'    => 'required',
            'code'          => 'required|string',
            'name'          => 'required|string',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Update', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $update = JobType::where([
                ['job_type_id', (int)$request->id],
            ])->firstOrFail();

            $update->fk_company_id = (int)$request->company_id;
            $update->job_type_code = strtoupper(trim($request->code));
            $update->job_type_name = ucwords(trim($request->name));
            $update->job_type_description = ucwords(trim($request->description));
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
                throw new \Exception("Param ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (JobType::where([
                ['job_type_id', (int)$request->id]
            ])->first()) {
                JobType::where([
                    ['job_type_id', (int)$request->id]
                ])->delete();
            } else {
                throw new \Exception("Job ID " . $request->id . " Not Found", Response::HTTP_BAD_REQUEST);
            }

            return $this->responseSuccess("Success Delete Job ID " . (int)$request->id);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", $e->getCode());
        }
    }
}
