<?php

namespace App\Providers;

use Illuminate\Support\Facades\View; // <-- Tambahkan ini
use App\View\Composers\NotificationComposer; // <-- Tambahkan ini
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
        // Memberitahu Laravel untuk menggunakan NotificationComposer
        // setiap kali view 'layouts.app' di-render.
        View::composer('layouts.app', NotificationComposer::class);
    }
}