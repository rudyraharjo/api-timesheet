<?php

namespace App\Http\Middleware;

use App\Traits\PermissionTrait;
use App\Traits\ResponseJsonTrait;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRolePermissionMiddleware
{

    use PermissionTrait, ResponseJsonTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module, $permission)
    {

        if (auth()->check() && auth()->user()->fk_role_id == 1) {
            return $next($request);
        } else if (auth()->user()->fk_role_id == 2) {
            if ($this->CheckPermission($module, $permission) == true) {
                return $next($request);
            }
        }

        return $this->responseError('Unauthorized Access', '', Response::HTTP_UNAUTHORIZED);
    }
}
