<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CareersController extends Controller
{
    /**
     * Display a listing of open positions for guests.
     */
    public function index()
    {
        $jobs = DB::table('jobs as j')
            ->leftJoin('companies as c', 'j.company_id', '=', 'c.company_id')
            ->leftJoin('departments as d', 'j.department', '=', 'd.department_id')
            ->select('j.*', 'c.name as company_name', 'd.department_name')
            ->where('j.status', 1)
            ->where('j.show_status', 1)
            ->orderBy('j.job_id', 'desc')
            ->get();

        return view('guest.careers.index', compact('jobs'));
    }

    /**
     * Show details for a specific job opening.
     */
    public function show($id)
    {
        $job = DB::table('jobs as j')
            ->leftJoin('companies as c', 'j.company_id', '=', 'c.company_id')
            ->leftJoin('departments as d', 'j.department', '=', 'd.department_id')
            ->select('j.*', 'c.name as company_name', 'd.department_name')
            ->where('j.job_id', $id)
            ->where('j.status', 1)
            ->where('j.show_status', 1)
            ->first();

        if (!$job) {
            abort(404, 'Job opening not found or has been closed.');
        }

        return view('guest.careers.show', compact('job'));
    }

    /**
     * Handle guest job applications.
     */
    public function apply(Request $request, $id)
    {
        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_no' => 'required|string|max:20',
            'job_resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = [
            'job_id'             => $id,
            'candidate_name'     => $request->candidate_name,
            'email'              => $request->email,
            'contact_no'         => $request->contact_no,
            'experience'         => $request->experience,
            'current_package'    => $request->current_package,
            'expected_package'   => $request->expected_package,
            'notice_period'      => $request->notice_period,
            'application_status' => 'Applied',
            'show_status'        => 1,
            'legacy_created_at'  => now(),
        ];

        // Handle Resume Upload to public/resume
        if ($request->hasFile('job_resume')) {
            $file = $request->file('job_resume');
            $filename = 'resume_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Ensure directory exists
            if (!file_exists(public_path('resume'))) {
                mkdir(public_path('resume'), 0755, true);
            }
            
            $file->move(public_path('resume'), $filename);
            $data['job_resume'] = $filename;
        }

        DB::table('job_applications')->insert($data);

        return redirect()->back()->with('success', 'Application submitted successfully! Our talent acquisition team will review your profile.');
    }
}
