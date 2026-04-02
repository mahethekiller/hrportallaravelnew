@extends('layouts.admin')

@section('page_title', 'HR Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <!-- HR Specific Widgets -->
    <div class="col-md-3">
        <div class="glass-card text-center p-4">
            <div class="text-primary mb-2"><i class="bi bi-people fs-1"></i></div>
            <h2 class="fw-bold mb-0 tracking-tight">{{ $stats['employees'] }}</h2>
            <div class="text-muted small fw-bold text-uppercase tracking-wider">Active Workforce</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card text-center p-4">
            <div class="text-accent mb-2" style="color: var(--accent) !important;"><i class="bi bi-briefcase fs-1"></i></div>
            <h2 class="fw-bold mb-0 tracking-tight">{{ $stats['jobs'] }}</h2>
            <div class="text-muted small fw-bold text-uppercase tracking-wider">Active Job Postings</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card text-center p-4">
            <div class="text-success mb-2"><i class="bi bi-person-plus fs-1"></i></div>
            <h2 class="fw-bold mb-0 tracking-tight">{{ $stats['candidates'] }}</h2>
            <div class="text-muted small fw-bold text-uppercase tracking-wider">Talent Pool</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card text-center p-4">
            <div class="text-warning mb-2"><i class="bi bi-calendar-check fs-1"></i></div>
            <h2 class="fw-bold mb-0 tracking-tight">{{ $stats['interviews'] }}</h2>
            <div class="text-muted small fw-bold text-uppercase tracking-wider">Interviews (Today)</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="glass-card pb-5">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="bg-primary-subtle p-3 rounded-4">
                    <i class="bi bi-display fs-3 text-primary"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Human Resources Command Center</h4>
                    <p class="text-muted mb-0">Centralized intelligence for workforce and recruitment management.</p>
                </div>
            </div>
            
            <div class="row g-4 mt-2">
                <div class="col-md-6">
                    <a href="{{ route('candidates.index') }}" class="text-decoration-none d-block">
                        <div class="p-4 rounded-4 border-dashed border border-primary-subtle hover-bg-light transition-all">
                            <h6 class="fw-bold mb-1"><i class="bi bi-person-badge me-2"></i>Manage Candidates</h6>
                            <p class="text-muted small mb-0">Screen, shortlist, and schedule interviews for the existing talent pool.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('jobs.index') }}" class="text-decoration-none d-block">
                        <div class="p-4 rounded-4 border-dashed border border-success-subtle hover-bg-light transition-all">
                            <h6 class="fw-bold mb-1 text-success"><i class="bi bi-plus-circle me-2"></i>Publish Job Opening</h6>
                            <p class="text-muted small mb-0">Create new requisitions or publish verified job postings to the website.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="glass-card">
            <h5 class="fw-bold mb-4">Upcoming Schedule</h5>
            <div class="text-center py-5">
                <i class="bi bi-calendar-x text-muted display-4"></i>
                <p class="text-muted mt-3 mb-0">No pending actions for today.</p>
            </div>
        </div>
    </div>
</div>
@endsection
