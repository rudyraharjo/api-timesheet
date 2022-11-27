<?php

namespace App\Http\Controllers\API;

use App\Models\Project;
use App\Models\Timesheet;
use App\Models\TimesheetActivity;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class TimesheetController extends MainController
{
    public function myTimesheet()
    {
        try {

            // $query = Timesheet::CompanyId($this->company_id)->with('employee', 'project');

            // if (!$this->is_root) {
            //     $query->where('fk_employee_id', $this->employee_id);
            // }

            // $timesheets = $query->get();

            // return $timesheets;

            $query = DB::table('timesheets as t')
                ->leftjoin('departments as d', 'd.department_id', '=', 't.fk_department_id')
                ->leftjoin('projects as p', 'p.project_id', '=', 't.fk_project_id')
                ->leftjoin('timesheet_activities as ta', 'ta.fk_timesheet_id', '=', 't.timesheet_id')
                ->leftjoin('employees as e', 'e.employee_id', '=', 'ta.fk_employee_id')
                ->select('t.*', 'd.department_name', 'p.project_title', 'ta.timesheet_activity_work_date', 'ta.timesheet_activity_duration', 'ta.timesheet_activity_notes', 'e.employee_id', 'e.employee_nik', 'e.employee_fullname');

            if ($this->company_id != 1) {
                $query->where('t.fk_company_id', $this->company_id);
            }

            if (!$this->is_root) {
                $query->where('t.fk_employee_id', $this->employee_id);
            }

            $timesheets = $query->get();


            $timesheet_activities = array();
            foreach ($timesheets as $t) {
                $timesheet_activities[$t->timesheet_id . '-' . $t->fk_project_id] = array(
                    "timesheet_id"      => $t->timesheet_id,
                    "project_id"        => $t->fk_project_id,
                    "project_title"     => $t->project_title,
                    "department_name"   => $t->department_name,
                    "timesheet_status"  => $t->timesheet_status,
                    "employee_id"       => $t->fk_employee_id,
                    "start_date"        => $t->timesheet_start_date,
                    "end_date"          => $t->timesheet_start_date,
                    "total_duration"    => $t->timesheet_total_duration,
                    "status"            => $t->timesheet_status,
                    "approve_id"        => $t->fk_approval_id,
                    "approve_date"      => $t->timesheet_approval_date,
                );
            }

            $timesheet_activities = array_values($timesheet_activities);

            // return $timesheet_activities;
            foreach ($timesheet_activities as $key => $ta) {
                foreach ($timesheets as $t) {
                    if ($ta["project_id"] == $t->fk_project_id && $ta["employee_id"] == $t->fk_employee_id) {
                        $timesheet_activities[$key]["activities"][] = array(
                            "activity_employee_id"          => $t->employee_id,
                            "activity_employee_nik"         => $t->employee_nik,
                            "activity_employee_fullname"    => $t->employee_fullname,
                            "activity_work_date"            => $t->timesheet_activity_work_date,
                            "activity_duration"             => $t->timesheet_activity_duration,
                            "activity_notes"                => $t->timesheet_activity_notes,
                        );
                    }
                }
            }

            return $this->responseSuccess($timesheet_activities);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'company_id'    => Rule::requiredIf($this->is_root),
            'employee_id'   => Rule::requiredIf($this->is_root),
            'department_id' => Rule::requiredIf($this->is_root),
            'project_id'    => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Create Timesheet', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        DB::beginTransaction();
        try {
            $start_date = date_create('this week')->format('Y-m-d H:i:s');
            $end_date = date_create('this week +4 days')->format('Y-m-d 23:59:00');
            $begin = new DateTime($start_date);
            $end   = new DateTime($end_date);

            // print_r($begin);
            // echo "<br/>";
            // print_r($end);
            // die();


            if (DB::table("project_assignment_departments")->where([
                ["fk_project_id", $request->project_id],
                ["fk_department_id", $this->department_id],
            ])->count() > 0) {

                $timeAdd = new Timesheet();
                $timeAdd->fk_company_id         = $this->company_id;
                $timeAdd->fk_department_id      = $this->department_id;
                $timeAdd->fk_employee_id        = $this->employee_id;
                $timeAdd->fk_project_id         = $request->project_id;
                $timeAdd->timesheet_start_date  = $start_date;
                $timeAdd->timesheet_end_date    = $end_date;
                $timeAdd->fk_project_id         = $request->project_id;
                if ($timeAdd->save()) {
                    $timesActivities = array();
                    for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
                        array_push($timesActivities, array(
                            'fk_timesheet_id'               => $timeAdd->timesheet_id,
                            'fk_employee_id'                => $timeAdd->fk_employee_id,
                            'timesheet_activity_work_date'  => $i->format("Y-m-d"),
                            'created_at'                    => date("Y-m-d H:i:s"),
                        ));
                    }
                } else {
                    throw new \Exception("Failed Created Timesheet", Response::HTTP_BAD_REQUEST);
                }

                if (count($timesActivities) > 0) {
                    $timesheetActivities = TimesheetActivity::insert($timesActivities);
                    if ($timesheetActivities) {
                        DB::commit();
                        return $this->responseSuccess($timeAdd, "Success Created Timesheet", Response::HTTP_CREATED);
                    } else {
                        throw new \Exception("Failed Created Timesheet", Response::HTTP_BAD_REQUEST);
                    }
                } else {
                    throw new \Exception("Failed Created Timesheet", Response::HTTP_BAD_REQUEST);
                }
            } else {
                throw new \Exception("Failed Created Timesheet, Department has not been assign this Project" . $request->project_id, Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'action'                => 'required|string',
            'employee_approvel_id'  => 'required|numeric'
        ]);

        if ($validate->fails()) {
            return $this->responseError('Failed Update Timesheet Please Check Params', $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $action = $request->action;
            $timesheets = count($request->timesheets) ? $request->timesheets : null;

            if (is_null($timesheets)) {
                throw new \Exception("Failed Update Timesheet, Timesheet Not Found", Response::HTTP_BAD_REQUEST);
            }

            if ($action === "submit") {
                $this->actionDraft($timesheets);
            } else if ($action === "posting") {
                $this->actionPosting($timesheets);
            } else if ($action === "approve") {
                $this->actionApprove($request->employee_approvel_id, $timesheets);
            } else {
                throw new \Exception("Failed Update Timesheet, Action Not Found", Response::HTTP_BAD_REQUEST);
            }

            return $this->responseSuccess("", "Success " . strtoupper($action) . " Timesheet", Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function actionDraft($timesheets = null)
    {
        foreach ($timesheets as $timesheet) {

            $time_draft = Timesheet::where("timesheet_id", $timesheet['timesheet_id'])
                ->where("fk_employee_id", $timesheet['employee_id'])
                ->where("timesheet_status", 0)
                ->first();

            if (isset($timesheet['activities']) && !is_null($timesheet['activities']) && count($timesheet['activities']) > 0) {
                foreach ($timesheet['activities'] as $activity) {
                    if ($time_draft) {
                        TimesheetActivity::where([
                            ["fk_timesheet_id", $time_draft->timesheet_id],
                            ["fk_employee_id", $time_draft->fk_employee_id],
                            ["timesheet_activity_work_date", $activity['work_date']],
                        ])->update([
                            "timesheet_activity_duration" => $activity['duration'],
                            "timesheet_activity_notes"    => $activity['notes'],
                            "updated_at"                  => date("Y-m-d H:i:s")
                        ]);
                    }
                }
            }

            if ($time_draft) {
                // update total_duration header timesheet
                DB::statement("
                    update
                    timesheets as t set
                    t.timesheet_total_duration = (
                        select
                            coalesce(sum(ta.timesheet_activity_duration), 0) as total_duration
                        from
                            timesheet_activities ta
                        where
                            ta.fk_timesheet_id = " . $timesheet['timesheet_id'] . "
                            and ta.fk_employee_id = " . $timesheet['employee_id'] . "
                    ) where t.timesheet_id = " . $timesheet['timesheet_id'] . " and t.fk_employee_id = " . $timesheet['employee_id'] . " and t.timesheet_status = 0
                ");
            }
        }
    }

    public function actionPosting($timesheets = null)
    {
        foreach ($timesheets as $timesheet) {
            Timesheet::where([
                ["timesheet_id", $timesheet["timesheet_id"]],
                ["fk_employee_id", $timesheet["employee_id"]],
                ["timesheet_status", 0]
            ])->update([
                "timesheet_status"  => 1,
                "updated_at"        => date("Y-m-d H:i:s")
            ]);
        }
    }

    public function actionApprove($approvel_id, $timesheets = null)
    {

        foreach ($timesheets as $timesheet) {
            Timesheet::where([
                ["timesheet_id", $timesheet["timesheet_id"]],
                ["fk_employee_id", $timesheet["employee_id"]]
            ])->update([
                "fk_approval_id"            => $approvel_id,
                "timesheet_status"          => 2,
                "timesheet_approval_date"   => date("Y-m-d H:i:s"),
                "updated_at"                => date("Y-m-d H:i:s")
            ]);
        }
    }
}
