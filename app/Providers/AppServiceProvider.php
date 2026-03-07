<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use illuminate\Support\Facades\URL;

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
        // 環境変数APP_ENVが'production'(本番環境)のとき
        if (config('app.env') === 'production') {
            // このアプリを全てのURLを強制的に'https'にする
            URL::forceScheme('https');
        }
    }
}
