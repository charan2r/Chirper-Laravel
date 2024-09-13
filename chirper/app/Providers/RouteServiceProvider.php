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
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for(name: 'api', callback: function (Request $request): Limit {
            return Limit::perMinute(maxAttempts: 60)->by(key: $request->user()?->id ?: $request->ip());
        });

        $this->routes(routesCallback: function (): void {
            Route::middleware(middleware: 'api')
                ->prefix(prefix: 'api')
                ->group(callback: base_path(path: 'routes/api.php'));

            Route::middleware(middleware: 'web')
                ->group(callback: base_path(path: 'routes/web.php'));
        });
    }
}
