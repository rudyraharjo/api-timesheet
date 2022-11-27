<?php

namespace App\Http\Controllers\API;

use App\Models\Project;
use App\Models\ProjectAssignmentDepartment;
use App\Traits\IssueTokenTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends MainController
{
    use IssueTokenTrait;

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'title'         => 'required|max:255|string',
            'start_date'    => 'required|date',
            'end_date'      => 'date|after:start_date',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Create Project', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $Project = new Project();
            $Project->fk_company_id = $this->company_id;
            $Project->fk_createdby_id = auth()->user()->user_id;
            $Project->project_title = trim($request->title);
            $Project->project_description = trim($request->description);
            $Project->project_start_date = $request->start_date;
            $Project->project_end_date = $request->start_date;

            $Project->save();

            return $this->responseSuccess($Project);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function read($id = null)
    {
        try {
            if (is_null($id)) {
                $result = Project::CompanyId($this->company_id)->with('tag')->orderByDesc('project_id')->paginate();
            } else {
                $result = Project::CompanyId($this->company_id)->with('tag')->where('project_id', $id)->firstOrFail();
            }
            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'title'         => 'required|max:255|string',
            'start_date'    => 'required|date',
            'end_date'      => 'date|after:start_date',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Update Project', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $Project = Project::CompanyId($this->company_id)->where([
                ['project_id', (int)$request->id],
            ])->firstOrFail();

            $Project->fk_company_id = $this->company_id;
            $Project->fk_createdby_id = auth()->user()->user_id;
            $Project->project_title = trim($request->title);
            $Project->project_description = trim($request->description);
            $Project->project_start_date = $request->start_date;
            $Project->project_end_date = $request->start_date;

            $Project->save();

            return $this->responseSuccess($Project);
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
            return $this->responseError('Failed Delete Project', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            if (Project::CompanyId($this->company_id)->where([
                ['project_id', (int)$request->id],
            ])->first()) {
                Project::CompanyId($this->company_id)->where([
                    ['project_id', (int)$request->id]
                ])->delete();
            } else {
                throw new \Exception("Project ID " . $request->id . " Not Found", Response::HTTP_BAD_REQUEST);
            }
            return $this->responseSuccess("Success Delete Project ID " . (int)$request->id);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", $e->getCode());
        }
    }

    public function read_assing_dept($id = null)
    {

        if (!is_null($id)) {
            $query = DB::table('project_assignment_departments as pads')
                ->leftjoin('projects as p', 'p.project_id', '=', 'pads.fk_project_id')
                ->leftjoin('departments as d', 'd.department_id', '=', 'pads.fk_department_id')
                ->select('pads.*', 'p.project_title', 'p.project_description', 'p.project_status', 'p.project_start_date', 'p.project_end_date', 'd.department_code', 'd.department_name')
                ->where('p.project_id', $id);

            if ($this->company_id != 1) {
                $query->where('p.fk_company_id', $this->company_id);
            }

            if (!$this->is_root) {
                $query->whereIn('pads.fk_department_id', [$this->department_id]);
            }

            $projects = $query->get();

            $headerProject = array();
            foreach ($projects as $pr) {

                $headerProject[$pr->fk_project_id] = array(
                    "project_id"    => $pr->fk_project_id,
                    "title"         => $pr->project_title,
                    "description"   => $pr->project_description,
                    "status"        => $pr->project_status,
                    "start_date"    => $pr->project_start_date,
                    "end_date"      => $pr->project_end_date,
                );
                // array_push($headerProject[$pr->fk_project_id], $data);
            }

            $ProjectAssignmentDpt = array();
            foreach ($headerProject as $hp) {
                $ProjectAssignmentDpt = $hp;

                foreach ($projects as $pr) {
                    $ProjectAssignmentDpt["department"][] = array(
                        "department_code"   => $pr->department_code,
                        "department_name"   => $pr->department_name,
                    );
                }
            }
        } else {

            $query = DB::table('project_assignment_departments as pads')
                ->leftjoin('projects as p', 'p.project_id', '=', 'pads.fk_project_id')
                ->leftjoin('departments as d', 'd.department_id', '=', 'pads.fk_department_id')
                ->select('pads.*', 'p.project_title', 'p.project_description', 'p.project_status', 'p.project_start_date', 'p.project_end_date', 'd.department_code', 'd.department_name');

            if ($this->company_id != 1) {
                $query->where('p.fk_company_id', $this->company_id);
            }

            if (!$this->is_root) {
                $query->whereIn('pads.fk_department_id', [$this->department_id]);
            }

            $projects = $query->get();

            $headerProject = array();
            foreach ($projects as $pr) {

                $data = array(
                    "project_id"    => $pr->fk_project_id,
                    "title"         => $pr->project_title,
                    "description"   => $pr->project_description,
                    "status"        => $pr->project_status,
                    "start_date"    => $pr->project_start_date,
                    "end_date"      => $pr->project_end_date,
                );

                $headerProject[$pr->fk_project_id] = $data;
                // print_r($data);

                // array_push($headerProject, $data);
            }

            $ProjectAssignmentDpt = array_values($headerProject);

            foreach ($ProjectAssignmentDpt as $key => $hp) {
                foreach ($projects as $pr) {
                    if ($hp["project_id"] == $pr->fk_project_id) {
                        $ProjectAssignmentDpt[$key]["department"][] = array(
                            "department_code"   => $pr->department_code,
                            "department_name"   => $pr->department_name,
                        );
                    }
                }
            }
        }

        return $this->responseSuccess($ProjectAssignmentDpt);
    }

    public function assing_dept(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'project_id'    => 'required'
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Assign Department to Project', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            if (ProjectAssignmentDepartment::where([
                ['fk_project_id', (int)$request->id],
            ])->count() > 0) {
                $Project = ProjectAssignmentDepartment::where([
                    ['project_id', (int)$request->id],
                ])->delete();
            }

            if (count($request->department_id) > 0) {
                $lastInstID = [];
                foreach ($request->department_id as $dpt) {
                    $ProjectAssignmentAdd = new ProjectAssignmentDepartment();
                    $ProjectAssignmentAdd->fk_project_id = $request->project_id;
                    $ProjectAssignmentAdd->fk_department_id = $dpt;
                    if ($ProjectAssignmentAdd->save()) {
                        array_push($lastInstID, $ProjectAssignmentAdd->project_assignment_department_id);
                    }
                }
            } else {
                throw new \Exception("Failed Assign Department to Project", Response::HTTP_BAD_REQUEST);
            }

            // $ProjectAssignment = ProjectAssignment::
            return $this->responseSuccess($lastInstID, "Success Assign PRoject To Department", Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
