<?php

// app/Providers/AuthServiceProvider.php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\students;
use App\Providers\CustomUserProvider; // Ensure you have this if needed

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('students', function ($app, array $config) {
            return new CustomUserProvider($app['hash'], students::class);
        });
    }
}
