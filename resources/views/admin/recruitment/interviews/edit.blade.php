@extends('layouts.admin')

@section('title', 'Edit Interview | i2u2 2.0')

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
    [data-theme="dark"] .form-control, [data-theme="dark"] .form-select {
        background: rgba(255, 255, 255, 0.05) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        color: #f1f5f9 !important;
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
    .interviewer-panel {
        max-height: 350px;
        overflow-y: auto;
        padding: 15px;
        border: 1px solid var(--glass-border);
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.02);
    }
    [data-theme="dark"] .btn-light {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        color: var(--text-main);
    }
    [data-theme="dark"] .hover-bg-light:hover { background: rgba(255,255,255,0.05) !important; }
    [data-theme="dark"] .form-check-label { color: var(--text-main); }
    [data-theme="dark"] .avatar-xs { background-color: rgba(255,255,255,0.1) !important; color: var(--accent) !important; }
    [data-theme="dark"] .bg-primary-subtle { background-color: rgba(79, 70, 229, 0.1) !important; }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <div class="mb-4">
        <h4 class="fw-bold mb-1"><i class="bi bi-calendar-event me-2 text-primary"></i>Edit Interview schedule</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('interviews.index') }}" class="text-decoration-none">Recruitment</a></li>
                <li class="breadcrumb-item active">Edit Schedule</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('interviews.update', $interview->job_interview_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card form-card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h6 class="section-title">Schedule & Candidate</h6>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="interview_date" class="form-control" value="{{ $interview->interview_date }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Time <span class="text-danger">*</span></label>
                                <input type="time" name="interview_time" class="form-control" value="{{ $interview->interview_time }}" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Position / Job Opening <span class="text-danger">*</span></label>
                                <select name="job_id" id="job_select" class="form-select" required>
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->job_id }}" {{ $job->job_id == $interview->job_id ? 'selected' : '' }}>{{ $job->job_title }} ({{ $job->job_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Candidate <span class="text-danger">*</span></label>
                                <select name="application_id" id="candidate_select" class="form-select" required>
                                    @foreach($candidates as $candidate)
                                        <option value="{{ $candidate->application_id }}" data-job="{{ $candidate->job_id }}" {{ $candidate->application_id == $interview->application_id ? 'selected' : '' }}>
                                            {{ $candidate->candidate_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-0">
                            <div class="col-md-6">
                                <label class="form-label">Interview Mode</label>
                                <select name="interview_mode" class="form-select">
                                    <option value="Virtual" {{ $interview->interview_mode == 'Virtual' ? 'selected' : '' }}>Virtual / Online (Zoom/Teams)</option>
                                    <option value="F2F" {{ $interview->interview_mode == 'F2F' ? 'selected' : '' }}>Face to Face (In-office)</option>
                                    <option value="Telephonic" {{ $interview->interview_mode == 'Telephonic' ? 'selected' : '' }}>Telephonic</option>
                                    <option value="Technical Test" {{ $interview->interview_mode == 'Technical Test' ? 'selected' : '' }}>Technical Assessment</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Interview Place / Link</label>
                                <input type="text" name="interview_place" class="form-control" value="{{ $interview->interview_place }}" placeholder="e.g. Noida HQ, Meeting Room 3">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card form-card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h6 class="section-title">Interview Panel (Employees)</h6>
                        <p class="text-muted small mb-3">Select one or more employees who will conduct this interview.</p>
                        
                        <div class="interviewer-panel">
                            <div class="row g-2">
                                @foreach($employees as $emp)
                                <div class="col-md-6">
                                    <div class="form-check border border-white-50 rounded p-2 ps-5 hover-bg-light transition-all">
                                        <input class="form-check-input ms-n5 mt-2" type="checkbox" name="interviewers[]" value="{{ $emp->user_id }}" id="emp_{{ $emp->user_id }}" {{ in_array($emp->user_id, $selected_interviewers) ? 'checked' : '' }}>
                                        <label class="form-check-label d-flex align-items-center" for="emp_{{ $emp->user_id }}">
                                            <div class="avatar-xs bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 25px; height: 25px; font-size: 0.7rem;">
                                                {{ strtoupper(substr($emp->first_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="small fw-bold">{{ $emp->first_name }} {{ $emp->last_name }}</div>
                                                <div class="text-muted" style="font-size: 0.7rem;">{{ $emp->email }}</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card form-card shadow-sm border-0 mb-4 sticky-top" style="top: 1rem;">
                    <div class="card-body p-4">
                        <h6 class="section-title">Logistics & Status</h6>
                        
                        <div class="mb-4">
                            <label class="form-label">Interview Status</label>
                            <select name="status" class="form-select">
                                <option value="confirmed" {{ $interview->status == 'confirmed' ? 'selected' : '' }}>Confirmed / Upcoming</option>
                                <option value="rescheduled" {{ $interview->status == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                                <option value="selected" {{ $interview->status == 'selected' ? 'selected' : '' }}>Selected / Pass</option>
                                <option value="rejected" {{ $interview->status == 'rejected' ? 'selected' : '' }}>Rejected / Fail</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Meeting Notes</label>
                            <textarea name="description" class="form-control" rows="5">{{ $interview->description }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">HR Feedback / Remarks</label>
                            <textarea name="remarks" class="form-control" rows="3">{{ $interview->remarks }}</textarea>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 shadow-sm">
                                <i class="bi bi-save me-2"></i>Update Interview
                            </button>
                            <a href="{{ route('interviews.index') }}" class="btn btn-light rounded-pill py-2">
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
