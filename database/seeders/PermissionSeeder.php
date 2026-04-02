<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // New granular permissions based on existing role logic
        $permissions = [
            // Resignations
            'view_all_resignations',
            'view_team_resignations',
            'approve_resignations_hr',
            'approve_resignations_manager',
            
            // Leaves
            'view_all_leaves',
            'view_team_leaves',
            'manage_leaves',      // Edit/Delete leave apps
            'manage_leave_types', // Manage the types settings
            
            // Attendance
            'view_all_attendance',
            'manage_attendance',  // Allows bulk operations etc.
            
            // Dashboards
            'view_hr_dashboard_stats',
            'view_manager_dashboard_stats',
            
            // Core HR basic access (if needed in future)
            'manage_employees'
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        // --- Assignment to existing base roles ---
        
        $superAdmin = Role::where('name', 'Super Admin')->first();
        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all()); // Super Admins get everything
        }

        $hrRole = Role::where('name', 'HR')->first();
        if ($hrRole) {
            $hrRole->givePermissionTo([
                'view_all_resignations',
                'approve_resignations_hr',
                'view_all_leaves',
                'manage_leaves',
                'manage_leave_types',
                'view_all_attendance',
                'manage_attendance',
                'view_hr_dashboard_stats',
                'manage_employees'
            ]);
        }

        $managerRole = Role::where('name', 'Manager')->first();
        if ($managerRole) {
            $managerRole->givePermissionTo([
                'view_team_resignations',
                'approve_resignations_manager',
                'view_team_leaves',
                'view_manager_dashboard_stats'
            ]);
        }
    }
}
