<?php

namespace App\Providers;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Policies\CategoryPolicy;
use App\Policies\DestinationPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;

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
        // Define gate Category
        Gate::define('category_list', [CategoryPolicy::class, 'view']);
        Gate::define('category_add', [CategoryPolicy::class, 'create']);
        Gate::define('category_edit', [CategoryPolicy::class, 'update']);
        Gate::define('category_delete', [CategoryPolicy::class, 'delete']);
        // Define gate Destination
        Gate::define('destination_list', [DestinationPolicy::class, 'view']);
        Gate::define('destination_add', [DestinationPolicy::class, 'create']);
        Gate::define('destination_edit', [DestinationPolicy::class, 'update']);
        Gate::define('destination_delete', [DestinationPolicy::class, 'delete']);
        // Define gate Tour
        Gate::define('tour_list', [DestinationPolicy::class, 'view']);
        Gate::define('tour_add', [DestinationPolicy::class, 'create']);
        Gate::define('tour_edit', [DestinationPolicy::class, 'update']);
        Gate::define('tour_delete', [DestinationPolicy::class, 'delete']);
        // Define gate Role
        Gate::define('role_list', [RolePolicy::class, 'view']);
        Gate::define('role_add', [RolePolicy::class, 'create']);
        Gate::define('role_edit', [RolePolicy::class, 'update']);
        Gate::define('role_delete', [RolePolicy::class, 'delete']);
        // Define gate User
        Gate::define('user_list', [UserPolicy::class, 'view']);
        Gate::define('user_add', [UserPolicy::class, 'create']);
        Gate::define('user_edit', [UserPolicy::class, 'update']);
        Gate::define('user_delete', [UserPolicy::class, 'delete']);
    }
}
