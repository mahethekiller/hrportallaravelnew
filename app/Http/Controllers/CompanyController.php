<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Company::query();
            
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('name', function($row) {
                    return '<div class="fw-bold text-dark">'.$row->name.'</div><small class="text-muted">'.$row->trading_name.'</small>';
                })
                ->addColumn('contact', function($row) {
                    return '<div><i class="bi bi-envelope text-primary me-1"></i> '.$row->email.'</div>' .
                           '<div><i class="bi bi-telephone text-success me-1"></i> '.$row->contact_number.'</div>';
                })
                ->addColumn('action', function($row){
                    $btn = '<button onclick="editCompany('.$row->company_id.')" class="btn btn-sm btn-light text-primary me-2 rounded-pill px-3 shadow-sm border-0"><i class="bi bi-pencil-square"></i> Edit</button>';
                    $btn .= '<button onclick="deleteCompany('.$row->company_id.')" class="btn btn-sm btn-light text-danger rounded-pill px-3 shadow-sm border-0"><i class="bi bi-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['name', 'contact', 'action'])
                ->make(true);
        }

        return view('admin.companies.index');
    }

    public function create()
    {
        // Return view for generic modal or page (Optional if using mostly AJAX)
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'trading_name' => 'nullable|string|max:150',
            'registration_no' => 'nullable|string|max:50',
            'email' => 'required|email|max:150',
            'contact_number' => 'required|string|max:50',
            'website_url' => 'nullable|url',
        ]);

        Company::create($validated);
        return response()->json(['success' => 'Company created successfully.']);
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return response()->json($company);
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'trading_name' => 'nullable|string|max:150',
            'registration_no' => 'nullable|string|max:50',
            'email' => 'required|email|max:150',
            'contact_number' => 'required|string|max:50',
            'website_url' => 'nullable|url',
        ]);

        $company->update($validated);
        return response()->json(['success' => 'Company updated successfully.']);
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json(['success' => 'Company deleted successfully.']);
    }

    public function getDepartments($company_id)
    {
        $departments = \App\Models\Department::where('company_id', $company_id)->get(['department_id', 'department_name']);
        return response()->json($departments);
    }
}
