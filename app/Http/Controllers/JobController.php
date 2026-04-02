<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function index()
    {
        $jobs = DB::table('jobs as j')
            ->leftJoin('companies as c', 'j.company_id', '=', 'c.company_id')
            ->leftJoin('departments as d', 'j.department', '=', 'd.department_id')
            ->select(
                'j.*', 
                'c.name as company_name', 
                'd.department_name',
                DB::raw("(SELECT COUNT(*) FROM job_applications WHERE job_id = j.job_id AND show_status = 1) as candidate_count")
            )
            ->where('j.show_status', 1)
            ->orderBy('j.job_id', 'desc')
            ->get();

        return view('admin.recruitment.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $companies = DB::table('companies')->get();
        $job_types = DB::table('job_type')->get();
        $departments = DB::table('departments')->get();
        return view('admin.recruitment.jobs.create', compact('companies', 'job_types', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_title' => 'required',
            'job_code' => 'required|unique:jobs,job_code',
            'company_id' => 'required',
            'job_type' => 'required',
            'job_vacancy' => 'required|integer',
        ]);

        $data = $request->except(['_token', 'add_type']);
        $data['show_status'] = 1;
        $data['legacy_created_at'] = now();
        
        DB::table('jobs')->insert($data);

        return redirect()->route('jobs.index')->with('success', 'Job opening published successfully!');
    }

    public function edit($id)
    {
        $job = DB::table('jobs')->where('job_id', $id)->first();
        $companies = DB::table('companies')->get();
        $job_types = DB::table('job_type')->get();
        $departments = DB::table('departments')->get();
        
        return view('admin.recruitment.jobs.edit', compact('job', 'companies', 'job_types', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'job_title' => 'required',
            'job_code' => 'required|unique:jobs,job_code,' . $id . ',job_id',
            'company_id' => 'required',
            'job_type' => 'required',
            'job_vacancy' => 'required|integer',
        ]);

        $data = $request->except(['_token', '_method', 'edit_type']);
        $data['updated_at'] = now();
        
        DB::table('jobs')->where('job_id', $id)->update($data);

        return redirect()->route('jobs.index')->with('success', 'Job opening updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('jobs')->where('job_id', $id)->update(['show_status' => 0]);
        return redirect()->route('jobs.index')->with('success', 'Job opening closed/archived');
    }
}
