<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use JWTAuth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Models\Model' => 'App\Policies\ModelPolicy',
         'App\Models\Request' => 'App\Policies\RequestPolicy',
    ];

    /**
     * Register any authentication / authorizatio services.
     *
     * @return void
     */
    public function register()
    {
       $this->app->singleton(\App\Models\User::class, function() {
            return JWTAuth::user();
       });
    }

    /**
     * Bootstrap any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is', function(\App\Models\User $user, $expectedRole) {
            return $user->role->name === $expectedRole
                    ? Response::allow()
                    : Response::deny("This action intended for ${expectedRole}s");
        });
    }
}
