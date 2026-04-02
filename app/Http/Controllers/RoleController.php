<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::query()->where('guard_name', 'web');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('permissions_count', function($row) {
                    return '<span class="badge bg-primary rounded-pill">'.$row->permissions->count().'</span>';
                })
                ->addColumn('action', function($row){
                    $btn = '<button onclick="editRole('.$row->id.')" class="btn btn-sm btn-light text-primary me-2 rounded-pill px-3 shadow-sm border-0"><i class="bi bi-pencil-square"></i> Edit</button>';
                    $btn .= '<button onclick="deleteRole('.$row->id.')" class="btn btn-sm btn-light text-danger rounded-pill px-3 shadow-sm border-0"><i class="bi bi-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['permissions_count', 'action'])
                ->make(true);
        }

        $allPermissions = Permission::all()->groupBy(function($item) {
            return explode('_', $item->name)[0] ?? 'general';
        });

        $allModules = \Illuminate\Support\Facades\DB::table('sidebar_modules')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('section');

        return view('admin.roles.index', compact('allPermissions', 'allModules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'nullable|array'
        ]);

        $exists = \Illuminate\Support\Facades\DB::table('roles')
            ->where('name', $request->name)
            ->where('guard_name', 'web')
            ->exists();

        if ($exists) {
            return response()->json(['errors' => ['name' => ['The name has already been taken.']]], 422);
        }

        $roleId = \Illuminate\Support\Facades\DB::table('roles')->insertGetId([
            'name' => $request->name,
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        if ($request->has('permissions')) {
            $this->manualSyncPermissions($roleId, $request->permissions);
        }

        // Sync sidebar modules
        $this->syncModules($roleId, $request->modules ?? []);

        return response()->json(['success' => 'Role created successfully.']);
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $assignedModules = \Illuminate\Support\Facades\DB::table('role_sidebar_modules')
            ->where('role_id', $id)
            ->pluck('sidebar_module_id')
            ->toArray();
        return response()->json([
            'role' => $role,
            'permissions' => $role->permissions->pluck('name'),
            'modules' => $assignedModules
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'nullable|array'
        ]);

        $exists = \Illuminate\Support\Facades\DB::table('roles')
            ->where('name', $request->name)
            ->where('guard_name', 'web')
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return response()->json(['errors' => ['name' => ['The name has already been taken.']]], 422);
        }

        // Use DB facade to avoid Laravel Eloquent Schema version compatibility errors
        \Illuminate\Support\Facades\DB::table('roles')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'updated_at' => now()
            ]);
        
        $this->manualSyncPermissions($id, $request->permissions ?? []);

        // Sync sidebar modules
        $this->syncModules($id, $request->modules ?? []);

        // Clear spatie cache just to be safe
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json(['success' => 'Role updated successfully.']);
    }

    private function manualSyncPermissions($roleId, array $permissionNames)
    {
        \Illuminate\Support\Facades\DB::table('role_has_permissions')->where('role_id', $roleId)->delete();

        if (!empty($permissionNames)) {
            $permissions = \Illuminate\Support\Facades\DB::table('permissions')
                ->whereIn('name', $permissionNames)
                ->where('guard_name', 'web')
                ->get();

            foreach ($permissions as $permission) {
                \Illuminate\Support\Facades\DB::table('role_has_permissions')->insert([
                    'permission_id' => $permission->id,
                    'role_id' => $roleId
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if ($role->name === 'Super Admin') {
            return response()->json(['error' => 'Super Admin role cannot be deleted.'], 403);
        }
        // Clean up module assignments
        \Illuminate\Support\Facades\DB::table('role_sidebar_modules')->where('role_id', $id)->delete();
        $role->delete();
        return response()->json(['success' => 'Role deleted successfully.']);
    }

    private function syncModules($roleId, array $moduleIds)
    {
        \Illuminate\Support\Facades\DB::table('role_sidebar_modules')->where('role_id', $roleId)->delete();
        foreach ($moduleIds as $moduleId) {
            \Illuminate\Support\Facades\DB::table('role_sidebar_modules')->insert([
                'role_id' => $roleId,
                'sidebar_module_id' => (int) $moduleId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
