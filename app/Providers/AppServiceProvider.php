<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
        Gate::define('manage-products', function ($user = null) {
            return $user instanceof \App\Models\Admin && $user->canManageProducts();
        });

        Gate::define('manage-categories', function ($user = null) {
            return $user instanceof \App\Models\Admin && $user->canManageCategories();
        });

        Gate::define('view-users', function ($user = null) {
            return $user instanceof \App\Models\Admin && $user->canViewUsers();
        });

        Gate::define('moderate-reviews', function ($user = null) {
            return $user instanceof \App\Models\Admin && $user->canModerateReviews();
        });

        Gate::define('manage-coupons', function ($user = null) {
            return $user instanceof \App\Models\Admin && $user->canManageCoupons();
        });

        Gate::define('super-admin-access', function ($user = null) {
            return $user instanceof \App\Models\Admin && $user->isSuperAdmin();
        });

        Gate::define('admin-access', function ($user = null) {
            return $user instanceof \App\Models\Admin && $user->isAdmin();
        });

        Gate::define('manager-access', function ($user = null) {
            return $user instanceof \App\Models\Admin && $user->isManager();
        });

        Gate::define('support-access', function ($user = null) {
            return $user instanceof \App\Models\Admin && $user->isSupport();
        });
    }
}
