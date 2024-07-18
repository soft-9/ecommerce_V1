<?php
namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

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
        Gate::define('accessFilament', function (User $user) {
            return $user->admin;
        });
        Filament::serving(function () {
            if (Auth::check() && Gate::denies('accessFilament')) {
                abort(403); 
            }
        });
    }
}

