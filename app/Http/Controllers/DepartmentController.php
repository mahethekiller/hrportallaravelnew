<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Join with companies to get the company name efficiently
            $query = Department::select('departments.*', 'companies.name as company_name')
                        ->leftJoin('companies', 'departments.company_id', '=', 'companies.company_id');
            
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('department', function($row) {
                    return '<div class="fw-bold text-dark">'.$row->department_name.'</div>' . 
                           '<small class="text-muted"><i class="bi bi-building me-1"></i> '.$row->company_name.'</small>';
                })
                ->addColumn('status_badge', function($row) {
                    return $row->status 
                        ? '<span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill">Active</span>' 
                        : '<span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 rounded-pill">Inactive</span>';
                })
                ->addColumn('action', function($row){
                    $btn = '<button onclick="editDepartment('.$row->department_id.')" class="btn btn-sm btn-light text-primary me-2 rounded-pill px-3 shadow-sm border-0"><i class="bi bi-pencil-square"></i> Edit</button>';
                    $btn .= '<button onclick="deleteDepartment('.$row->department_id.')" class="btn btn-sm btn-light text-danger rounded-pill px-3 shadow-sm border-0"><i class="bi bi-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['department', 'status_badge', 'action'])
                ->make(true);
        }

        $companies = Company::select('company_id', 'name')->orderBy('name')->get();
        return view('admin.departments.index', compact('companies'));
    }

    public function create()
    {
        // Handled via modal in index
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:150',
            'company_id' => 'required|integer|exists:companies,company_id',
            'status' => 'required|boolean',
        ]);

        // Automatically assign who added it
        $validated['added_by'] = auth()->id();

        Department::create($validated);
        return response()->json(['success' => 'Department created successfully.']);
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return response()->json($department);
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        
        $validated = $request->validate([
            'department_name' => 'required|string|max:150',
            'company_id' => 'required|integer|exists:companies,company_id',
            'status' => 'required|boolean',
        ]);

        $department->update($validated);
        return response()->json(['success' => 'Department updated successfully.']);
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return response()->json(['success' => 'Department deleted successfully.']);
    }

    public function getDesignations($department_id)
    {
        $designations = \App\Models\Designation::where('department_id', $department_id)->get(['designation_id', 'designation_name']);
        return response()->json($designations);
    }
}
