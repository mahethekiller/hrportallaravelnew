<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::query()->where('guard_name', 'web');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('group', function($row) {
                    return '<span class="badge bg-light text-dark border rounded-pill">'.(explode('_', $row->name)[0] ?? 'general').'</span>';
                })
                ->addColumn('action', function($row){
                    $btn = '<button onclick="deletePermission('.$row->id.')" class="btn btn-sm btn-light text-danger rounded-pill px-3 shadow-sm border-0"><i class="bi bi-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['group', 'action'])
                ->make(true);
        }

        return view('admin.permissions.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        // Manual unique check to avoid schema inspection in 'unique' rule
        $exists = \Illuminate\Support\Facades\DB::table('permissions')
            ->where('name', $request->name)
            ->where('guard_name', 'web')
            ->exists();

        if ($exists) {
            return response()->json(['errors' => ['name' => ['The name has already been taken.']]], 422);
        }

        \Illuminate\Support\Facades\DB::table('permissions')->insert([
            'name' => $request->name,
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => 'Permission created successfully.']);
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return response()->json(['success' => 'Permission deleted successfully.']);
    }
}
