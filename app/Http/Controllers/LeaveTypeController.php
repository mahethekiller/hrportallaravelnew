<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveTypeController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('manage_leave_types')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $types = LeaveType::orderBy('type_name')->get();
        return response()->json(['data' => $types]);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'HR', 'Branch Admin'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'type_name' => 'required',
            'days_per_year' => 'required|numeric|min:0'
        ]);

        $type = new LeaveType();
        $type->type_name = $request->type_name;
        $type->days_per_year = $request->days_per_year;
        $type->company_id = Auth::user()->company_id ?? 1;
        $type->status = 1;
        $type->save();

        return response()->json(['success' => true, 'message' => 'Leave type added successfully!']);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'HR', 'Branch Admin'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $type = LeaveType::findOrFail($id);
        
        if ($request->has('status')) {
            $type->status = $request->status;
        }
        if ($request->has('type_name')) {
            $type->type_name = $request->type_name;
        }
        if ($request->has('days_per_year')) {
            $type->days_per_year = $request->days_per_year;
        }
        
        $type->save();

        return response()->json(['success' => true, 'message' => 'Leave type updated successfully!']);
    }

    public function destroy($id)
    {
        if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'HR', 'Branch Admin'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $type = LeaveType::findOrFail($id);
        $type->delete();

        return response()->json(['success' => true, 'message' => 'Leave type deleted successfully!']);
    }
}
