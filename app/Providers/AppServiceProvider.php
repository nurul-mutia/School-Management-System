<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // <--- Import ini untuk Gate
use App\Models\User;                  // <--- Import ini untuk User
use Carbon\Carbon;                    // <--- Import ini untuk tanggal Indonesia

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
        // Set format tanggal Indonesia
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        // Gate hak akses admin
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });
    }
}