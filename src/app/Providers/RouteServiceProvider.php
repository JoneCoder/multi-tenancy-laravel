<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }


    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {

        $this->configureRateLimiting();

        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapTenantRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->domain(config('tenant.master_domain'))
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }


    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    public function mapWebRoutes(): void
    {

        Route::middleware(['web', 'check.master.domain'])
        ->domain(config('tenant.master_domain'))
        ->namespace($this->namespace)
        ->group(base_path('routes/web.php'));

    }


    /**
     * Define the "Tenant" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    public function mapTenantRoutes(): void
    {
        Route::middleware(['tenant', 'web'])
        ->domain('{subdomain}.'.config('tenant.master_domain'))
        ->namespace($this->namespace)
        ->group(base_path('routes/tenant.php'));

    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
