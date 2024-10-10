<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if( Auth::user()->system_role == null){
            DB::table('oauth_access_tokens')
                ->where("user_id", Auth::user()->id)
                ->delete();

            Auth::logout();
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect('login')->with('warning',"Your request for membership is not yet accepted by the administrator!");

        }

        if(Auth::user()->account_status==0){
            DB::table('oauth_access_tokens')
                ->where("user_id", Auth::user()->id)
                ->delete();
            Auth::logout();
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect('login')->with('warning',"Your account is locked! You can have access again when the admin unlock it.");

        }
        return $next($request);
    }
}
