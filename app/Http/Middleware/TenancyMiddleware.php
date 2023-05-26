<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use \Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class TenancyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() && auth()->user()->isSuperAdmin) {
            view()->composer('*', function($view) {
                $view->with('tenantsForAdmin', Tenant::all());
            });
        }

        $response = $next($request);
        Cookie::forget('tenant');
        Cookie::queue(Cookie::forever('tenant', encrypt(auth()->user()->tenant->database)));
        return $response;
    }
}
