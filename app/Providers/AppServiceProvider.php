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
        // gate admin: cuma email ini yang boleh akses halaman admin
        \Illuminate\Support\Facades\Gate::define('admin', function ($user) {
            return $user->email === 'khoirunnaimmian@gmail.com'; // <- GANTI: email admin lu
        });
    }
}
