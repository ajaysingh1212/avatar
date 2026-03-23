<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Wallet;

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

        // ✅ ROLE & PERMISSION SYSTEM
        Gate::before(function ($user, $ability) {

            if ($user->roles->contains('slug','super-admin')) {
                return true;
            }

            if ($user->hasPermission($ability)) {
                return true;
            }

        });


        // ✅ WALLET GLOBAL SHARE
        View::composer('*', function ($view) {

            $wallet = null;

            if(auth()->check()){
                $wallet = Wallet::where('user_id', auth()->id())->first();
            }

            $view->with('authWallet', $wallet);
        });

    }
}
