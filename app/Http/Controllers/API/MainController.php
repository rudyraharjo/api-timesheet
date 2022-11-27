<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as BaseController;
use App\Traits\IssueTokenTrait;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;

class MainController extends BaseController
{
    use ResponseJsonTrait, IssueTokenTrait;

    protected $is_root;
    protected $company_id;
    protected $branch_id;
    protected $department_id;
    protected $employee_id;

    public function __construct(Request $request)
    {
        $this->is_root = $this->payloadJWT()["is_root"];
        $this->company_id = $request->company_id ? (int)$request->company_id : (int)$this->payloadJWT()["company_id"];
        $this->branch_id = $request->branch_id ? (int)$request->branch_id : (int)$this->payloadJWT()["branch_id"];
        $this->department_id = $request->department_id ? (int)$request->department_id : (int)$this->payloadJWT()["department_id"];
        $this->employee_id = $request->employee_id ? (int)$request->employee_id : (int)$this->payloadJWT()["employee_id"];
    }
}
