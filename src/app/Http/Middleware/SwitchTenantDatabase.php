<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Tenant\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SwitchTenantDatabase
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
        $manger = app(TenantManager::class);

        $tenant = App::make( 'siteTenancy' );

        if($tenant && !$manger->isMasterDomain($request)){
            $manger->setConnection($tenant);
        }else{
            abort(404, __('auth.subdomain.404'));
        }

        return $next($request);
    }
}
