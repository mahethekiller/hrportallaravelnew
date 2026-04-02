<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DesignationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Designation::with(['company', 'department']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('designation', function($row) {
                    return $row->designation_name;
                })
                ->addColumn('organization', function($row) {
                    $comp = $row->company ? $row->company->name : 'N/A';
                    $dept = $row->department ? $row->department->department_name : 'N/A';
                    return $comp . ' / ' . $dept;
                })
                ->addColumn('action', function($row){
                    $btn = '<button onclick="editDesignation('.$row->designation_id.')" class="btn btn-sm btn-light text-primary me-1 rounded-pill shadow-sm border-0"><i class="bi bi-pencil"></i></button>';
                    $btn .= '<button onclick="deleteDesignation('.$row->designation_id.')" class="btn btn-sm btn-light text-danger rounded-pill shadow-sm border-0"><i class="bi bi-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $companies = Company::all();
        $departments = Department::all();
        return view('admin.designations.index', compact('companies', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'designation_name' => 'required',
            'company_id' => 'required',
            'department_id' => 'required',
        ]);

        Designation::create([
            'designation_name' => $request->designation_name,
            'company_id' => $request->company_id,
            'department_id' => $request->department_id,
            'added_by' => 1,
            'status' => 1
        ]);

        return response()->json(['success' => 'Designation created successfully.']);
    }

    public function edit($id)
    {
        return response()->json(Designation::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $designation = Designation::findOrFail($id);
        $request->validate([
            'designation_name' => 'required',
            'company_id' => 'required',
            'department_id' => 'required',
        ]);

        $designation->update($request->all());
        return response()->json(['success' => 'Designation updated successfully.']);
    }

    public function destroy($id)
    {
        Designation::findOrFail($id)->delete();
        return response()->json(['success' => 'Designation deleted successfully.']);
    }
}
