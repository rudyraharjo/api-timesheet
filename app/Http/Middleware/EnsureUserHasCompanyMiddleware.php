<?php

namespace App\Http\Middleware;

use App\Traits\ResponseJsonTrait;
use App\Traits\UserCompanyTrait;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasCompanyMiddleware
{
    use UserCompanyTrait, ResponseJsonTrait;
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
        } else if (auth()->check() && auth()->user()->fk_role_id == 2) {
            $company_id =  $request->company_id ? (int)$request->company_id : (int)auth()->payload()["company_id"];

            // dd($company_id);

            if (!is_null($company_id) || !empty($company_id)) {
                if ($this->CheckUserHasCompany($company_id, auth()->user()->user_id) === true) {
                    return $next($request);
                } else {
                    return $this->responseError('Unauthorized Access, Anda tidak ditugaskan di Company ID ' . $company_id, '', Response::HTTP_UNAUTHORIZED);
                }
            }
        }

        return $this->responseError('Unauthorized Access', '', Response::HTTP_UNAUTHORIZED);
    }
}
