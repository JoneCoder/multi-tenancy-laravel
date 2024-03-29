<?php

namespace App\Providers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*-----TENANT SETTINGS-----*/
        /*$this->app->singleton( 'siteTenancy', function ( $app ) {
            $request    = app(\Illuminate\Http\Request::class);
            $tenant     = Tenant::where('subdomain', $request->subdomain)->first();
            return $tenant ?? [];
        } );*/

        $this->app->singleton( 'siteTenancy', function ( $app ) {
            $request = app(Request::class);
            return Cache::rememberForever( $request->subdomain.'site_tenancy', function ()use($request){
                $tenant = Tenant::where('subdomain', $request->subdomain)->first();
                return $tenant ?? [];
            } );
        } );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
