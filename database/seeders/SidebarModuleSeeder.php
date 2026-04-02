<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SidebarModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            // General (visible to all by default)
            ['name' => 'Dashboard',         'slug' => 'dashboard',        'icon' => 'bi-grid-1x2',          'route' => 'dashboard',            'active_match' => 'routeIs:dashboard',              'section' => 'general',       'sort_order' => 1],
            ['name' => 'Attendance',        'slug' => 'attendance',       'icon' => 'bi-clock-history',     'route' => 'attendance.index',     'active_match' => 'routeIs:attendance.*',            'section' => 'general',       'sort_order' => 2],
            ['name' => 'Leave Management',  'slug' => 'leaves',           'icon' => 'bi-calendar2-x',       'route' => 'leaves.index',         'active_match' => 'routeIs:leaves.*',                'section' => 'general',       'sort_order' => 3],
            ['name' => 'Resignations',      'slug' => 'resignations',     'icon' => 'bi-door-open',         'route' => 'resignations.index',   'active_match' => 'is:admin/resignations*',          'section' => 'general',       'sort_order' => 4],

            // Core HR
            ['name' => 'Employees',         'slug' => 'employees',        'icon' => 'bi-people',            'route' => 'employees.index',      'active_match' => 'is:admin/employees*',             'section' => 'core_hr',       'sort_order' => 10],
            ['name' => 'Companies',         'slug' => 'companies',        'icon' => 'bi-building',          'route' => 'companies.index',      'active_match' => 'routeIs:companies.*',             'section' => 'core_hr',       'sort_order' => 11],
            ['name' => 'Departments',       'slug' => 'departments',      'icon' => 'bi-diagram-3',         'route' => 'departments.index',    'active_match' => 'routeIs:departments.*',           'section' => 'core_hr',       'sort_order' => 12],
            ['name' => 'Sub Departments',   'slug' => 'sub_departments',  'icon' => 'bi-diagram-2',         'route' => 'sub_departments.index','active_match' => 'routeIs:sub_departments.*',       'section' => 'core_hr',       'sort_order' => 13],
            ['name' => 'Designations',      'slug' => 'designations',     'icon' => 'bi-award',             'route' => 'designations.index',   'active_match' => 'routeIs:designations.*',          'section' => 'core_hr',       'sort_order' => 14],

            // Talent Acquisition
            ['name' => 'Job Openings',      'slug' => 'jobs',             'icon' => 'bi-briefcase',         'route' => 'jobs.index',           'active_match' => 'is:admin/recruitment/jobs*',      'section' => 'recruitment',   'sort_order' => 20],
            ['name' => 'Candidate Hub',     'slug' => 'candidates',       'icon' => 'bi-person-badge',      'route' => 'candidates.index',     'active_match' => 'is:admin/recruitment/candidates*','section' => 'recruitment',   'sort_order' => 21],
            ['name' => 'Interviews',        'slug' => 'interviews',       'icon' => 'bi-calendar-check',    'route' => 'interviews.index',     'active_match' => 'is:admin/recruitment/interviews*','section' => 'recruitment',   'sort_order' => 22],
            ['name' => 'Job Requests',      'slug' => 'job_requests',     'icon' => 'bi-file-earmark-plus', 'route' => 'requests.index',       'active_match' => 'is:admin/recruitment/requests*',  'section' => 'recruitment',   'sort_order' => 23],
            ['name' => 'Career Board',      'slug' => 'careers',          'icon' => 'bi-globe2',            'route' => 'careers.index',        'active_match' => 'none',                            'section' => 'recruitment',   'sort_order' => 24, 'is_external' => true],

            // Access Control
            ['name' => 'Roles',             'slug' => 'roles',            'icon' => 'bi-shield-lock',       'route' => 'roles.index',          'active_match' => 'routeIs:roles.*',                 'section' => 'access_control','sort_order' => 30],
            ['name' => 'Permissions',       'slug' => 'permissions',      'icon' => 'bi-key',               'route' => 'permissions.index',    'active_match' => 'routeIs:permissions.*',           'section' => 'access_control','sort_order' => 31],
        ];

        foreach ($modules as $module) {
            DB::table('sidebar_modules')->updateOrInsert(
                ['slug' => $module['slug']],
                array_merge($module, [
                    'is_active' => $module['is_active'] ?? true,
                    'is_external' => $module['is_external'] ?? false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        // Auto-assign ALL modules to Super Admin role
        $superAdminRole = DB::table('roles')->where('name', 'Super Admin')->first();
        if ($superAdminRole) {
            $allModules = DB::table('sidebar_modules')->pluck('id');
            foreach ($allModules as $moduleId) {
                DB::table('role_sidebar_modules')->updateOrInsert(
                    ['role_id' => $superAdminRole->id, 'sidebar_module_id' => $moduleId],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }

        // Assign common modules to all existing roles
        $commonSlugs = ['dashboard', 'attendance', 'leaves', 'resignations'];
        $commonIds = DB::table('sidebar_modules')->whereIn('slug', $commonSlugs)->pluck('id');
        $allRoles = DB::table('roles')->where('name', '!=', 'Super Admin')->pluck('id');
        foreach ($allRoles as $roleId) {
            foreach ($commonIds as $moduleId) {
                DB::table('role_sidebar_modules')->updateOrInsert(
                    ['role_id' => $roleId, 'sidebar_module_id' => $moduleId],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }

        // Assign HR-specific modules
        $hrRole = DB::table('roles')->where('name', 'HR')->first();
        if ($hrRole) {
            $hrSlugs = ['employees', 'companies', 'departments', 'sub_departments', 'designations', 'jobs', 'candidates', 'interviews', 'job_requests', 'careers'];
            $hrIds = DB::table('sidebar_modules')->whereIn('slug', $hrSlugs)->pluck('id');
            foreach ($hrIds as $moduleId) {
                DB::table('role_sidebar_modules')->updateOrInsert(
                    ['role_id' => $hrRole->id, 'sidebar_module_id' => $moduleId],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }

        // Assign Manager modules
        $mgrRole = DB::table('roles')->where('name', 'Manager')->first();
        if ($mgrRole) {
            $mgrSlugs = ['employees'];
            $mgrIds = DB::table('sidebar_modules')->whereIn('slug', $mgrSlugs)->pluck('id');
            foreach ($mgrIds as $moduleId) {
                DB::table('role_sidebar_modules')->updateOrInsert(
                    ['role_id' => $mgrRole->id, 'sidebar_module_id' => $moduleId],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
