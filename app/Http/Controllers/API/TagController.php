<?php

namespace App\Http\Controllers\API;

use App\Models\Tag;
use App\Traits\IssueTokenTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class TagController extends MainController
{
    use IssueTokenTrait;

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'project_id'    => 'required',
            'name'          => 'required|string',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Create Tag', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $tag = new Tag();
            $tag->fk_company_id = $this->company_id;
            $tag->fk_project_id = (int)$request->project_id;
            $tag->tag_slug = Str::slug($request->name, '-');
            $tag->tag_name = ucwords(trim($request->name));
            $tag->save();
            return $this->responseSuccess($tag);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function read($id = null)
    {
        try {
            if (is_null($id)) {
                $result = Tag::CompanyId($this->company_id)->orderByDesc('tag_id')->paginate();
            } else {
                $result = Tag::CompanyId($this->company_id)->where('tag_id', $id)->firstOrFail();
            }
            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id'            => 'required',
            'company_id'    => Rule::requiredIf($this->is_root),
            'project_id'    => 'required',
            'name'          => 'required|string',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Update Tag', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $tag = Tag::CompanyId($this->company_id)->where([
                ['tag_id', (int)$request->id],
            ])->firstOrFail();

            $tag->fk_company_id = $this->company_id;
            $tag->fk_project_id = (int)$request->project_id;
            $tag->tag_slug = Str::slug($request->name, '-');
            $tag->tag_name = ucwords(trim($request->name));
            $tag->save();

            return $this->responseSuccess($tag);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Request $request)
    {
        try {

            $validate = Validator::make($request->all(), [
                'id'            => 'required',
                'company_id'    => Rule::requiredIf($this->is_root)
            ]);

            if ($validate->fails()) {
                return $this->responseError('Failed Delete Tag', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (Tag::CompanyId($this->company_id)->where([
                ['tag_id', (int)$request->id],
            ])->first()) {
                Tag::CompanyId($this->company_id)->where([
                    ['tag_id', (int)$request->id]
                ])->delete();
            } else {
                throw new \Exception("Tag ID " . $request->id . " Not Found", Response::HTTP_BAD_REQUEST);
            }
            return $this->responseSuccess("Success Delete Tag ID " . (int)$request->id);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", $e->getCode());
        }
    }
}
