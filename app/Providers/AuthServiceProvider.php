<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('index',   'App\Policies\UserPolicy@index');
        Gate::define('show',    'App\Policies\UserPolicy@show');
        Gate::define('create',  'App\Policies\UserPolicy@create');
        Gate::define('store',   'App\Policies\UserPolicy@store');
        Gate::define('edit',    'App\Policies\UserPolicy@edit');
        Gate::define('update',  'App\Policies\UserPolicy@update');
        Gate::define('destroy', 'App\Policies\UserPolicy@destroy');
        Gate::define('import',  'App\Policies\UserPolicy@create');
        Gate::define('export',  'App\Policies\UserPolicy@index');
        Gate::define('getjson', 'App\Policies\UserPolicy@index');
        Gate::define('reset',   'App\Policies\UserPolicy@edit');
        Gate::define('approve', 'App\Policies\UserPolicy@edit');
        Gate::define('status',  'App\Policies\UserPolicy@edit');
        Gate::define('export',  'App\Policies\UserPolicy@index');

        \Illuminate\Support\Facades\Auth::provider('customuserprovider', function ($app, array $config) {
            return new CustomUserProvider($app['hash'], $config['model']);
        });
    }
}
