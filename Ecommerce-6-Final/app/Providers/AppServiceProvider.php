<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
    public function boot()
    {
        Password::defaults(function () {
            $rule = Password::min(8)
                ->mixedCase()//one uppercase letter required
                ->numbers()//one number required
                ->symbols()//one symbol required
                ->uncompromised();

            // IF THIS LINE EXISTS, IT'S THE CULPRIT FOR THE ERROR WITHOUT password_confirmation
            // ->confirmed(); // <--- REMOVE THIS IF YOU DON'T WANT CONFIRMATION

            return $rule;
        });
    }
}
