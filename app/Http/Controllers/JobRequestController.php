<?php

namespace App\Http\Controllers;

use App\Models\JobRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobRequestController extends Controller
{
    public function index()
    {
        $requests = DB::table('job_requests as r')
            ->leftJoin('companies as c', 'r.company_id', '=', 'c.company_id')
            ->leftJoin('departments as d', 'r.department_id', '=', 'd.department_id')
            ->leftJoin('employees as e', 'r.added_by', '=', 'e.user_id')
            ->select('r.*', 'c.name as company_name', 'd.department_name', 'e.first_name', 'e.last_name')
            ->where('r.show_status', 1)
            ->orderBy('r.added_date', 'desc')
            ->get();

        return view('admin.recruitment.requests.index', compact('requests'));
    }

    public function approve($id)
    {
        $requisition = DB::table('job_requests')->where('request_id', $id)->first();
        if (!$requisition) {
            return redirect()->back()->with('error', 'Requisition not found');
        }

        DB::beginTransaction();
        try {
            // Update Req status
            DB::table('job_requests')->where('request_id', $id)->update([
                'approve_status' => 1,
                'updated_date' => now()
            ]);

            // Create Job Opening
            DB::table('jobs')->insert([
                'job_title' => $requisition->post_name,
                'job_code' => 'REQ-' . $requisition->request_id . '-' . time(),
                'company_id' => $requisition->company_id,
                'department' => $requisition->department_id,
                'job_type' => 1, // Default Full Time
                'job_vacancy' => $requisition->vacancies,
                'short_description' => 'Hiring Request #' . $requisition->request_id . ': ' . $requisition->post_name,
                'long_description' => $requisition->description,
                'status' => 1,
                'show_status' => 1,
                'legacy_created_at' => now(),
                'show_on_website' => 'yes'
            ]);

            DB::commit();
            return redirect()->route('jobs.index')->with('success', 'Hiring request approved and new job opening published!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to approve request: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        DB::table('job_requests')->where('request_id', $id)->update([
            'approve_status' => 2,
            'updated_date' => now()
        ]);
        
        return redirect()->back()->with('error', 'Job request rejected.');
    }

    public function create()
    {
        $companies = DB::table('companies')->get();
        $departments = DB::table('departments')->get();
        return view('admin.recruitment.requests.create', compact('companies', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_name' => 'required',
            'vacancies' => 'required|integer',
            'company_id' => 'required',
            'department_id' => 'required',
        ]);

        $data = $request->except(['_token']);
        $data['approve_status'] = 0; // Pending
        $data['show_status'] = 1;
        $data['added_date'] = now();
        $data['added_by'] = auth()->id() ?? 1;

        DB::table('job_requests')->insert($data);

        return redirect()->route('requests.index')->with('success', 'Hiring request submitted for approval!');
    }
    public function edit($id)
    {
        $request = DB::table('job_requests')->where('request_id', $id)->first();
        if (!$request) {
            return redirect()->route('requests.index')->with('error', 'Hiring request not found');
        }
        $companies = DB::table('companies')->get();
        $departments = DB::table('departments')->get();
        return view('admin.recruitment.requests.edit', compact('request', 'companies', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'post_name' => 'required',
            'vacancies' => 'required|integer',
            'company_id' => 'required',
            'department_id' => 'required',
        ]);

        $data = $request->except(['_token', '_method']);
        $data['updated_date'] = now();

        DB::table('job_requests')->where('request_id', $id)->update($data);

        return redirect()->route('requests.index')->with('success', 'Hiring request updated successfully!');
    }
}
