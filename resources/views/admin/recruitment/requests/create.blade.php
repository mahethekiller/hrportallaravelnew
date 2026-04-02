@extends('layouts.admin')

@section('title', 'Submit Hiring Request | i2u2 2.0')

@push('styles')
<style>
    .form-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
    }
    .form-label { font-weight: 600; color: var(--text-main); margin-bottom: 0.5rem; }
    .form-control, .form-select {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 0.75rem 1.25rem;
        color: var(--text-main);
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        background: rgba(255, 255, 255, 0.1);
        border-color: var(--accent);
        box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
        color: var(--text-main);
    }
    .input-group-text {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid var(--glass-border);
        color: var(--text-muted);
    }
    [data-theme="dark"] .form-control, [data-theme="dark"] .form-select {
        background: rgba(255, 255, 255, 0.05) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        color: #f1f5f9 !important;
    }
    [data-theme="dark"] .input-group-text {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.1);
        color: #94a3b8;
    }
    .section-title {
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: var(--accent);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .section-title::after {
        content: "";
        height: 1px;
        flex-grow: 1;
        background: linear-gradient(to right, var(--accent), transparent);
        opacity: 0.3;
    }
    [data-theme="dark"] .btn-light {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        color: var(--text-main);
    }
    [data-theme="dark"] .form-check-label { color: var(--text-main); }
    [data-theme="dark"] .text-muted { color: #94a3b8 !important; }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <div class="mb-4">
        <h4 class="fw-bold mb-1"><i class="bi bi-file-earmark-plus me-2 text-primary"></i>New Hiring Requisition</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('requests.index') }}" class="text-decoration-none">Recruitment</a></li>
                <li class="breadcrumb-item active">New Request</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('requests.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card form-card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h6 class="section-title">Requisition Details</h6>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-8">
                                <label class="form-label">Positon / Job Title Required <span class="text-danger">*</span></label>
                                <input type="text" name="post_name" class="form-control" placeholder="e.g. Frontend Specialist" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">No. of Vacancies <span class="text-danger">*</span></label>
                                <input type="number" name="vacancies" class="form-control" value="1" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Target Company <span class="text-danger">*</span></label>
                                <select name="company_id" class="form-select" required>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->company_id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department <span class="text-danger">*</span></label>
                                <select name="department_id" class="form-select" required>
                                    <option value="">Select Department</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->department_id }}">{{ $dept->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Justification / Reason for Hire</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Why is this headcount needed? (e.g. New Project, Backfill, Expansion)"></textarea>
                        </div>
                    </div>
                </div>

                <div class="card form-card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h6 class="section-title">Requirements & Budget</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Experience Range (Min - Max)</label>
                                <div class="input-group">
                                    <input type="number" name="min_experience" class="form-control" placeholder="Min">
                                    <span class="input-group-text">to</span>
                                    <input type="number" name="max_experience" class="form-control" placeholder="Max">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Salary Budget (Monthly)</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" name="min_salary" class="form-control" placeholder="Min">
                                    <span class="input-group-text">-</span>
                                    <input type="text" name="max_salary" class="form-control" placeholder="Max">
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-0">
                            <div class="col-md-6">
                                <label class="form-label">Position Level</label>
                                <select name="position_level" class="form-select">
                                    <option value="Junior">Junior / Entry Level</option>
                                    <option value="Mid">Mid Level</option>
                                    <option value="Senior" selected>Senior Level</option>
                                    <option value="Lead">Lead / Management</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Priority</label>
                                <select name="priority" class="form-select">
                                    <option value="Normal">Normal</option>
                                    <option value="Urgent">Urgent</option>
                                    <option value="Replacement">Replacement</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card form-card shadow-sm border-0 mb-4 sticky-top" style="top: 1rem;">
                    <div class="card-body p-4">
                        <h6 class="section-title">Submit For Approval</h6>
                        
                        <p class="text-muted small">Your request will be sent to the HR Admin and Finance for tiered approval.</p>

                        <div class="mb-4">
                            <label class="form-label">Desired Hiring Rounds</label>
                            <input type="number" name="interview_rounds" class="form-control" value="2">
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 shadow-sm">
                                <i class="bi bi-send-check me-2"></i>Send Request
                            </button>
                            <a href="{{ route('requests.index') }}" class="btn btn-light rounded-pill py-2">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
