<?php

namespace App\Http\Middleware;

use App\Constants\AppConstants;
use App\Exceptions\UserException;
use App\Services\Api\AuthService;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $role = auth()->user()->role;
        // if($role != "Admin"){
        //     throw new UserException("Unauthorized Request");
        // }
        return $next($request);
    }
}
