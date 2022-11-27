<?php

namespace App\Http\Controllers\API;

use App\Models\JobTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class JobTitleController extends MainController
{
    public function create(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'department_id' => 'required',
            'title_name'    => 'required|string',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Create Job Title', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            if (JobTitle::where([
                ['fk_department_id', (int)$request->department_id],
                ['job_title_name', $request->title_name]
            ])->count() == 0) {

                $add = new JobTitle();
                $add->fk_department_id = (int)$request->department_id;
                $add->job_title_name = ucwords(trim($request->title_name));
                $add->save();

                return $this->responseSuccess($add);
            } else {
                $data["name"][] = "Job Title '" . strtoupper(trim($request->title_name)) . "' is already in use";
                return $this->responseError('Failed Create Job Title', $data, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function read($id = null)
    {
        try {
            if (is_null($id)) {
                $result = JobTitle::orderByDesc('job_title_id')->paginate();
            } else {
                $result = JobTitle::where('job_title_id', $id)->firstOrFail();
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
            'department_id' => 'required',
            'title_name'    => 'required|string',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Update', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $update = JobTitle::where([
                ['job_title_id', (int)$request->id],
            ])->firstOrFail();

            $update->fk_department_id = (int)$request->department_id;
            $update->job_title_name = ucwords(trim($request->title_name));
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
                throw new \Exception("Param Job Title ID is required", Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (JobTitle::where([
                ['job_title_id', (int)$request->id]
            ])->first()) {
                JobTitle::where([
                    ['job_title_id', (int)$request->id]
                ])->delete();
            } else {
                throw new \Exception("Job Title ID " . $request->id . " Not Found", Response::HTTP_BAD_REQUEST);
            }

            return $this->responseSuccess("Success Delete Job Title ID " . (int)$request->id);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", $e->getCode());
        }
    }
}
