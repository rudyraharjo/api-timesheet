<?php

namespace App\Http\Controllers\API;

use App\Models\Employee;
use App\Traits\PermissionTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PermissionUserController extends MainController
{

    use PermissionTrait;

    public function read()
    {
        $module_access = array();

        if (auth()->user()->fk_role_id == 1) {
            $msg = "Get All Modules";
        } else if (auth()->user()->fk_role_id == 2) {
            $employee = Employee::where('fk_user_id', auth()->user()->user_id)->first();
            $module_access = $this->HasPermission($employee);
            $msg = "List Module Access";
        } else {
            $msg = "No Access Module";
        }

        return $this->responseSuccess($module_access, $msg, Response::HTTP_ACCEPTED);
    }

    public function AssignPermission(Request $request)
    {
        $msg = '';
        $module_app = $request->all();

        try {

            if (count($module_app) > 0) {
                $data_perm = array();
                foreach ($module_app as $app) {

                    if (!empty($app['module_app_id']) && !empty($app['param']) && !empty($app['value'])) {

                        $HasPermission = DB::table('permission_users as pu')
                            ->where('pu.module_app_id', $app['module_app_id'])
                            ->where('pu.param', $app['param'])
                            ->where('pu.value', $app['value']);

                        $has_permissions = $HasPermission->get();

                        if (count($app['permission']) > 0 && $HasPermission->count() == 0) {
                            foreach ($app['permission'] as $perm) {
                                $data_perm[] = array(
                                    'module_app_id' => $app['module_app_id'],
                                    'permission_id' => $perm,
                                    'param'         => $app['param'],
                                    'value'         => $app['value'],
                                    'created_at'    => date('Y-m-d H:i:s'),
                                    'updated_at'    => date('Y-m-d H:i:s'),
                                );
                            }
                        } else {

                            if (count($has_permissions) > 0) {
                                foreach ($has_permissions as $h_perm) {
                                    $where_permissions_id[] = $h_perm->permission_id;
                                }
                            }

                            foreach ($app['permission'] as $perm) {
                                if (!in_array($perm, $where_permissions_id, true)) {
                                    $data_perm[] = array(
                                        'module_app_id' => $app['module_app_id'],
                                        'permission_id' => $perm,
                                        'param'         => $app['param'],
                                        'value'         => $app['value'],
                                        'created_at'    => date('Y-m-d H:i:s'),
                                        'updated_at'    => date('Y-m-d H:i:s'),
                                    );
                                }
                            }
                        }
                    } else {
                        $msg = 'Failed Update Module Permission';
                    }
                }

                if (count($data_perm) > 0) {
                    $msg = 'Success Update Module Permission';
                    DB::table('permission_users')->insert($data_perm);
                    $statusCode = Response::HTTP_CREATED;
                } else {
                    $statusCode = Response::HTTP_OK;
                }

                return $this->responseSuccess($data_perm, $msg, $statusCode);
            } else {
                return $this->responseError('Failed Assign Module to Permission', "", Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (Exception $e) {
            return $this->responseError($e->getMessage(), "", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
