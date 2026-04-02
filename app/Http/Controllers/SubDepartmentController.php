<?php

namespace App\Http\Controllers;

use App\Models\SubDepartment;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubDepartmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = SubDepartment::select('sub_departments.*', 'companies.name as company_name', 'departments.department_name as parent_department')
                        ->leftJoin('companies', 'sub_departments.company_id', '=', 'companies.company_id')
                        ->leftJoin('departments', 'sub_departments.department_id', '=', 'departments.department_id');
            
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('sub_department', function($row) {
                    $parent = $row->parent_department ? '<small class="text-muted"><i class="bi bi-diagram-3 me-1"></i> '.$row->parent_department.'</small>' : '';
                    $company = $row->company_name ? '<small class="text-muted"><i class="bi bi-building me-1"></i> '.$row->company_name.'</small>' : '';
                    return '<div class="fw-bold text-dark">'.$row->department_name.'</div>' . $parent . '<br>' . $company;
                })
                ->addColumn('status_badge', function($row) {
                    return $row->show_status 
                        ? '<span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill">Active</span>' 
                        : '<span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 rounded-pill">Inactive</span>';
                })
                ->addColumn('action', function($row){
                    $btn = '<button onclick="editSubDepartment('.$row->sub_department_id.')" class="btn btn-sm btn-light text-primary me-2 rounded-pill px-3 shadow-sm border-0"><i class="bi bi-pencil-square"></i> Edit</button>';
                    $btn .= '<button onclick="deleteSubDepartment('.$row->sub_department_id.')" class="btn btn-sm btn-light text-danger rounded-pill px-3 shadow-sm border-0"><i class="bi bi-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['sub_department', 'status_badge', 'action'])
                ->make(true);
        }

        $companies = Company::select('company_id', 'name')->orderBy('name')->get();
        $departments = Department::select('department_id', 'department_name', 'company_id')->orderBy('department_name')->get();
        return view('admin.sub_departments.index', compact('companies', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:150',
            'company_id' => 'required|integer|exists:companies,company_id',
            'department_id' => 'required|integer|exists:departments,department_id',
            'show_status' => 'required|integer',
        ]);

        $validated['added_by'] = auth()->id();

        SubDepartment::create($validated);
        return response()->json(['success' => 'Sub Department created successfully.']);
    }

    public function edit($id)
    {
        $subDepartment = SubDepartment::findOrFail($id);
        return response()->json($subDepartment);
    }

    public function update(Request $request, $id)
    {
        $subDepartment = SubDepartment::findOrFail($id);
        
        $validated = $request->validate([
            'department_name' => 'required|string|max:150',
            'company_id' => 'required|integer|exists:companies,company_id',
            'department_id' => 'required|integer|exists:departments,department_id',
            'show_status' => 'required|integer',
        ]);

        $subDepartment->update($validated);
        return response()->json(['success' => 'Sub Department updated successfully.']);
    }

    public function destroy($id)
    {
        $subDepartment = SubDepartment::findOrFail($id);
        $subDepartment->delete();
        return response()->json(['success' => 'Sub Department deleted successfully.']);
    }

    /**
     * Get sub-departments for a given department (cascading AJAX).
     */
    public function getSubDepartments($department_id)
    {
        $subDepartments = SubDepartment::where('department_id', $department_id)
            ->where('show_status', 1)
            ->get(['sub_department_id', 'department_name']);
        return response()->json($subDepartments);
    }
}
