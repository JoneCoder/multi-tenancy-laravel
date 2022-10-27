<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Tenant\TenantManager;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class SwitchTenantDatabase
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
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
