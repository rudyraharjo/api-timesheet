<?php

namespace App\Http\Middleware;

use App\Traits\ResponseJsonTrait;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class MustBeAdminMiddleware
{
    use ResponseJsonTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (auth()->check() && auth()->user()->fk_role_id == 1) {
            return $next($request);
        }

        return $this->responseError('Unauthorized Access', '', Response::HTTP_UNAUTHORIZED);
    }
}
