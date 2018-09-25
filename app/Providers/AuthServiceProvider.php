<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */

    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('thread-view', 'App\Policies\ThreadPolicy@view');
        Gate::define('thread-reply', 'App\Policies\ThreadPolicy@reply');
        Gate::define('thread-create', 'App\Policies\ThreadPolicy@create');

        Gate::define('user-register', 'App\Policies\UserPolicy@register');
        Gate::define('user-view', 'App\Policies\UserPolicy@view');
        Gate::define('user-update', 'App\Policies\UserPolicy@update');
    }
}
