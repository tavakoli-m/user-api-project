<?php

namespace App\Providers;

use App\Http\Services\ApiResponse\Facades\ApiResponse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
class RequestLimiterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip())->response(function (Request $request){
                return ApiResponse::withStatus(429)->withMessage("To Many Requests, Please Try Again Later")->send();
            });
        });
    }
}
