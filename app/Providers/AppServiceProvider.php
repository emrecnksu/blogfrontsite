<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $apiBaseUrl = config('app.api_base_url');

            $categoriesResponse = Http::get("{$apiBaseUrl}/api/categories");
            $categories = $categoriesResponse->successful() ? $categoriesResponse->json()['data'] : [];

            $view->with('categories', $categories);
        });
    }
}
