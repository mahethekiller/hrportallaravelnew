<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncLegacyRoles extends Command
{
    protected $signature = 'app:sync-legacy-roles';
    protected $description = 'Imports CI roles to Spatie and migrates super-admins to Employees';

    public function handle()
    {
        $this->info("Migrating Roles to Spatie...");
        $legacyRoles = \Illuminate\Support\Facades\DB::table('user_roles')->get();
        $roleMap = [];
        
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \Illuminate\Support\Facades\DB::table('model_has_roles')->truncate();
        \Illuminate\Support\Facades\DB::table('roles')->truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($legacyRoles as $lr) {
            $roleId = \Illuminate\Support\Facades\DB::table('roles')->insertGetId([
                'name' => $lr->role_name, 
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $roleMap[$lr->role_id] = $roleId;
        }

        $this->info("Assigning Spatie roles to existing employees...");
        $employees = \App\Models\Employee::all();
        foreach ($employees as $employee) {
            if (isset($roleMap[$employee->user_role_id])) {
                \Illuminate\Support\Facades\DB::table('model_has_roles')->insert([
                    'role_id' => $roleMap[$employee->user_role_id],
                    'model_type' => 'App\Models\Employee',
                    'model_id' => $employee->user_id
                ]);
            }
        }

        $this->info("Porting legacy Super Admins to unified Employee authentication...");
        $legacyAdmins = \Illuminate\Support\Facades\DB::table('users')->get();
        
        $superAdminRoleId = $roleMap[1] ?? null;

        foreach ($legacyAdmins as $admin) {
            $exists = \App\Models\Employee::where('username', $admin->username)->first();
            if (!$exists) {
                // Generate secure bcrypt password
                $password = \Illuminate\Support\Facades\Hash::make($admin->password);
                
                \Illuminate\Support\Facades\Config::set('database.connections.mysql.strict', false);
                \Illuminate\Support\Facades\DB::reconnect('mysql');

                $newAdminId = \Illuminate\Support\Facades\DB::table('employees')->insertGetId([
                    'first_name' => $admin->first_name ?? 'Super',
                    'last_name' => $admin->last_name ?? 'Admin',
                    'username' => $admin->username,
                    'email' => $admin->email ?? ($admin->username.'@admin.local'),
                    'password' => $password,
                    'user_role_id' => 1,
                    'employee_id' => "ADMIN-" . \Illuminate\Support\Str::random(5),
                    'is_active' => 1
                ]);

                if ($superAdminRoleId) {
                    \Illuminate\Support\Facades\DB::table('model_has_roles')->insert([
                        'role_id' => $superAdminRoleId,
                        'model_type' => 'App\Models\Employee',
                        'model_id' => $newAdminId
                    ]);
                }
                $this->info("Migrated Super Admin: {$admin->username}");
            }
        }

        $this->info("Auth & Roles completely migrated and unified!");
    }
}
