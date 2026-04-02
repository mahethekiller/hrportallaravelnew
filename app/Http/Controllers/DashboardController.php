<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Intercept the core dashboard route and serve the appropriate view module.
     */
    public function index()
    {
        $user = Auth::user();

        // High priority: System Configuration and Global Overview
        if ($user->hasRole('Super Admin')) {
            return view('dashboards.admin');
        } 
        
        // Mid priority: Departmental and Personnel management
        elseif ($user->can('view_hr_dashboard_stats') || $user->can('view_manager_dashboard_stats')) {
            $stats = [
                'employees' => \DB::table('employees')->where('is_active', 1)->count(),
                'jobs' => \DB::table('jobs')->where('show_status', 1)->count(),
                'candidates' => \DB::table('job_applications')->where('show_status', 1)->count(),
                'interviews' => \DB::table('job_interviews')->where('interview_date', date('Y-m-d'))->where('show_status', 1)->count(),
            ];
            return view('dashboards.hr', compact('stats'));
        } 
        
        // Default: Personal Employee Self Service
        else {
            return view('dashboards.employee');
        }
    }
}
