@extends('layouts.admin')

@section('page_title', 'Self Service Portal')

@section('content')
<div class="row g-4 mb-4">
    <!-- Employee Personal Widgets -->
    <div class="col-md-4">
        <div class="glass-card text-center p-4 border-0" style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white;">
            <div class="mb-2"><i class="bi bi-clock-history fs-1 text-white-50"></i></div>
            <h4 class="fw-bold text-white mb-2">Punch In</h4>
            <p class="small text-white-50 mb-4">Current Shift: 09:00 AM - 05:00 PM</p>
            <button class="btn btn-light rounded-pill px-4 fw-bold text-primary shadow-sm">Mark Attendance</button>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card text-center p-4">
            <div class="text-primary mb-2"><i class="bi bi-wallet2 fs-1"></i></div>
            <h3 class="fw-bold mb-3">Latest Payslip</h3>
            <button class="btn btn-outline-primary rounded-pill px-4 btn-sm"><i class="bi bi-download me-1"></i> Download PDF</button>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card text-center p-4">
            <div class="text-warning mb-2"><i class="bi bi-calendar-event fs-1"></i></div>
            <h3 class="fw-bold mb-0">14 Days</h3>
            <div class="text-muted small fw-semibold text-uppercase tracking-wide mb-3">Remaining Leave Balance</div>
            <button class="btn btn-light rounded-pill px-4 btn-sm">Request Leave</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="glass-card pb-5">
            <h5 class="fw-bold mb-3">Recent Announcements</h5>
            <div class="alert alert-light border shadow-sm rounded-4 p-3 d-flex align-items-center mb-3">
                <div class="bg-primary text-white p-2 rounded-circle me-3"><i class="bi bi-megaphone"></i></div>
                <div>
                    <h6 class="mb-1 fw-bold">Welcome to HRMS 2.0</h6>
                    <small class="text-muted">The new portal is live. Ensure you update your profile details under settings.</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card pb-5">
            <h5 class="fw-bold mb-3">Upcoming Holidays</h5>
            <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                <span class="fw-semibold">New Year's Day</span>
                <span class="text-muted small">01 Jan</span>
            </div>
            <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                <span class="fw-semibold">Labor Day</span>
                <span class="text-muted small">01 May</span>
            </div>
        </div>
    </div>
</div>
@endsection
