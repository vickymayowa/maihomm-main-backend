<?php

namespace App\Http\Middleware;

use App\Constants\NotificationConstants;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyKycMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $user = auth()->user();
        if (!$user->isVerified()) {
            $parameters = !empty($request->redirect_url) ? ["redirect_url" => $request->redirect_url] : null;
            return redirect()->route("dashboard.user.profile-page", $parameters)->with(NotificationConstants::INFO_MSG, "Complete you KYC before proceeding");
        }
        return $next($request);
    }
}
