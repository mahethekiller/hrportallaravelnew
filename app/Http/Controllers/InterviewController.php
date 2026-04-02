<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InterviewController extends Controller
{
    public function index()
    {
        $interviews = DB::table('job_interviews as i')
            ->leftJoin('job_applications as app', 'i.application_id', '=', 'app.application_id')
            ->leftJoin('jobs as j', 'i.job_id', '=', 'j.job_id')
            ->select('i.*', 'app.candidate_name', 'app.email as candidate_email', 'j.job_title')
            ->where('i.show_status', 1)
            ->orderBy('i.interview_date', 'desc')
            ->get();

        return view('admin.recruitment.interviews.index', compact('interviews'));
    }

    public function create(Request $request)
    {
        $selected_application_id = $request->get('application_id');
        $jobs = DB::table('jobs')->where('show_status', 1)->get();
        // Only show candidates who are in 'Applied' or 'Interviewing' status
        $candidates = DB::table('job_applications')->where('show_status', 1)->get();
        $employees = DB::table('employees')->where('is_active', 1)->get();
        
        return view('admin.recruitment.interviews.create', compact('jobs', 'candidates', 'employees', 'selected_application_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'required',
            'application_id' => 'required',
            'interview_date' => 'required|date',
            'interview_time' => 'required',
            'interviewers' => 'required|array',
            'interview_mode' => 'required',
        ]);

        $data = $request->except(['_token', 'interviewers']);
        
        // Convert interviewers array to comma-separated string for legacy compatibility
        $data['interviewers_id'] = implode(',', $request->interviewers);
        
        $data['status'] = 'confirmed'; // Default status
        $data['show_status'] = 1;
        $data['legacy_created_at'] = now();
        $data['added_by'] = auth()->id() ?? 1;

        DB::table('job_interviews')->insert($data);

        // Update candidate status to 'Interview Scheduled'
        DB::table('job_applications')
            ->where('application_id', $request->application_id)
            ->update(['application_status' => 'Interview Scheduled']);

        return redirect()->route('interviews.index')->with('success', 'Interview scheduled and candidate notified!');
    }

    public function edit($id)
    {
        $interview = DB::table('job_interviews')->where('job_interview_id', $id)->first();
        $jobs = DB::table('jobs')->where('show_status', 1)->get();
        $candidates = DB::table('job_applications')->where('show_status', 1)->get();
        $employees = DB::table('employees')->where('is_active', 1)->get();
        
        $selected_interviewers = explode(',', $interview->interviewers_id);
        
        return view('admin.recruitment.interviews.edit', compact('interview', 'jobs', 'candidates', 'employees', 'selected_interviewers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'job_id' => 'required',
            'application_id' => 'required',
            'interview_date' => 'required|date',
            'interview_time' => 'required',
            'interviewers' => 'required|array',
            'interview_mode' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'interviewers']);
        $data['interviewers_id'] = implode(',', $request->interviewers);
        $data['updated_at'] = now();

        DB::table('job_interviews')->where('job_interview_id', $id)->update($data);

        return redirect()->route('interviews.index')->with('success', 'Interview schedule updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('job_interviews')->where('job_interview_id', $id)->update(['show_status' => 0]);
        return redirect()->route('interviews.index')->with('success', 'Interview schedule cancelled/removed');
    }
}
