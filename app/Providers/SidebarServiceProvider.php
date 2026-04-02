<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SidebarServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('layouts.admin', function ($view) {
            $sidebarModules = collect();

            if (Auth::check() && Schema::hasTable('sidebar_modules')) {
                $user = Auth::user();

                // Get user's role IDs
                $roleIds = DB::table('model_has_roles')
                    ->where('model_id', $user->user_id ?? $user->id)
                    ->where('model_type', 'App\\Models\\Employee')
                    ->pluck('role_id');

                // Check if user is Super Admin (bypass = see everything)
                $isSuperAdmin = DB::table('roles')
                    ->whereIn('id', $roleIds)
                    ->where('name', 'Super Admin')
                    ->exists();

                if ($isSuperAdmin) {
                    $sidebarModules = DB::table('sidebar_modules')
                        ->where('is_active', true)
                        ->orderBy('sort_order')
                        ->get();
                } else {
                    // Get modules assigned to user's roles
                    $moduleIds = DB::table('role_sidebar_modules')
                        ->whereIn('role_id', $roleIds)
                        ->pluck('sidebar_module_id')
                        ->unique();

                    $sidebarModules = DB::table('sidebar_modules')
                        ->whereIn('id', $moduleIds)
                        ->where('is_active', true)
                        ->orderBy('sort_order')
                        ->get();
                }
            }

            // Group by section
            $sidebarGrouped = $sidebarModules->groupBy('section');

            $view->with('sidebarModules', $sidebarModules);
            $view->with('sidebarGrouped', $sidebarGrouped);
        });
    }

    public function register(): void
    {
        //
    }
}
