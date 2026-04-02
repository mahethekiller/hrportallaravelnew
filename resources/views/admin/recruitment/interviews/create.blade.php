@extends('layouts.admin')

@section('title', 'Schedule Interview | i2u2 2.0')

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
        <h4 class="fw-bold mb-1"><i class="bi bi-calendar-plus me-2 text-primary"></i>Schedule New Interview</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('interviews.index') }}" class="text-decoration-none">Recruitment</a></li>
                <li class="breadcrumb-item active">Schedule</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('interviews.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card form-card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h6 class="section-title">Schedule & Candidate</h6>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="interview_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Time <span class="text-danger">*</span></label>
                                <input type="time" name="interview_time" class="form-control" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Position / Job Opening <span class="text-danger">*</span></label>
                                <select name="job_id" id="job_select" class="form-select" required>
                                    <option value="">Select Job</option>
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->job_id }}">{{ $job->job_title }} ({{ $job->job_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Candidate <span class="text-danger">*</span></label>
                                <select name="application_id" id="candidate_select" class="form-select" required>
                                    <option value="">Select Job First</option>
                                    @foreach($candidates as $candidate)
                                        <option value="{{ $candidate->application_id }}" 
                                                data-job="{{ $candidate->job_id }}"
                                                {{ $selected_application_id == $candidate->application_id ? 'selected' : '' }}>
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
                                    <option value="Virtual">Virtual / Online (Zoom/Teams)</option>
                                    <option value="F2F">Face to Face (In-office)</option>
                                    <option value="Telephonic">Telephonic</option>
                                    <option value="Technical Test">Technical Assessment</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Interview Place / Link</label>
                                <input type="text" name="interview_place" class="form-control" placeholder="e.g. Noida HQ, Meeting Room 3">
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
                                        <input class="form-check-input ms-n5 mt-2" type="checkbox" name="interviewers[]" value="{{ $emp->user_id }}" id="emp_{{ $emp->user_id }}">
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
                        <h6 class="section-title">Logistics</h6>
                        
                        <div class="mb-4">
                            <label class="form-label">Expected DOJ</label>
                            <input type="date" name="expected_doj" class="form-control">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Meeting Notes</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Preparation notes for interviewers..."></textarea>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 shadow-sm">
                                <i class="bi bi-calendar-check me-2"></i>Schedule Interview
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

@push('scripts')
<script>
    $(document).ready(function() {
        // If a candidate is pre-selected, select the correct job automatically
        var preselectedCandidate = $('#candidate_select option:selected');
        if(preselectedCandidate.val()) {
            var jobId = preselectedCandidate.data('job');
            $('#job_select').val(jobId).trigger('change');
            
            // Re-show correctly after change event hides them
            setTimeout(function() {
                $('#candidate_select option').hide();
                $('#candidate_select option[data-job="' + jobId + '"]').show();
                $('#candidate_select').val(preselectedCandidate.val());
            }, 10);
        }

        // Simple filtering for candidates based on job
        $('#job_select').on('change', function() {
            var jobId = $(this).val();
            if(jobId) {
                $('#candidate_select option').hide();
                $('#candidate_select option[data-job="' + jobId + '"]').show();
                
                // Keep pre-selected candidate if it matches the current job
                var currentSelected = $('#candidate_select').val();
                if(!currentSelected || $('#candidate_select option:selected').data('job') != jobId) {
                    $('#candidate_select').val('');
                }
                
                if(!$('#candidate_select option:selected').val()) {
                     $('#candidate_select').prepend('<option value="" selected disabled>Select Candidate</option>');
                }
            } else {
                $('#candidate_select option').show();
            }
        });
    });
</script>
@endpush
