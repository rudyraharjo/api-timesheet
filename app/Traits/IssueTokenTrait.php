<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Arr;

trait IssueTokenTrait
{

    protected function createToken($account = null, $credentials = null)
    {

        $result = array();
        $token = auth()->setTTL(config('jwt.ttl'))->claims(
            [
                'is_root'       => $account['user_role_id'] == 1 ? true : false,
                'role'          => $account['user_role_id'],
                'employee_id'   => $account["employee_id"] ?? null,
                'branch_id'     => $account["employee_branch_id"] ?? null,
                'department_id' => $account["employee_department_id"] ?? null,
                'company_id'    => $account["employee_company_id"] ?? 1 // 1 is company_id for dev_eco
            ]
        )->attempt($credentials);

        // dd($token);

        $minutes = auth()->factory()->getTTL() * 1;
        $timestamp = Carbon::now()->addMinute($minutes);
        $expires_at = date('M d, Y H:i A', strtotime($timestamp));

        if ($token) {
            $result = array(
                'account'   => $account,
                'meta'      => [
                    'token_type' => 'bearer',
                    'access_token' => $token,
                    'expires_at'    => $expires_at,
                    'expires_in' => $minutes . " Minutes"
                ]
            );
        }


        return $result;
    }

    protected function refreshToken()
    {
        $newToken = auth()->refresh();
        $minutes = auth()->factory()->getTTL() * 1;
        $timestamp = Carbon::now()->addMinute($minutes);
        $expires_at = date('M d, Y H:i A', strtotime($timestamp));

        $result = array(
            'meta'      => [
                'token_type' => 'bearer',
                'access_token' => $newToken,
                'expires_at'    => $expires_at,
                'expires_in' => $minutes . " Minutes"
            ]
        );

        return $result;
    }

    protected function payloadJWT()
    {
        $payload = auth()->payload();
        return $payload->toArray();
    }
}
