<?php

namespace App\Providers;

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
        view()->composer("*", function ($view) {
            $view->with([
                "logo_image" => my_asset("logo.png"),
                "logo_text_image" => my_asset("logo_text.png"),
                "logo_icon_image" => my_asset("logo_icon.png"),
                'web_assets' => url('/') . env('RESOURCE_PATH') . '/assets',
            ]);
        });
    }
}
