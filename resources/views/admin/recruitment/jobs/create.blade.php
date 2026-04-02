@extends('layouts.admin')

@section('title', 'Post New Job | i2u2 2.0')

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
    [data-theme="dark"] .form-control::placeholder { color: #64748b; }
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
    [data-theme="dark"] .form-check-input { background-color: rgba(255,255,255,0.1); border-color: var(--glass-border); }
    [data-theme="dark"] .form-check-input:checked { background-color: var(--accent); border-color: var(--accent); }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <div class="mb-4">
        <h4 class="fw-bold mb-1"><i class="bi bi-plus-circle me-2 text-primary"></i>Post New Job opening</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}" class="text-decoration-none">Recruitment</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}" class="text-decoration-none">Openings</a></li>
                <li class="breadcrumb-item active">New Post</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('jobs.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <!-- Left Column: Core Info -->
            <div class="col-lg-8">
                <div class="card form-card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h6 class="section-title">Job Information</h6>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-8">
                                <label class="form-label">Job Title / Position <span class="text-danger">*</span></label>
                                <input type="text" name="job_title" class="form-control" placeholder="e.g. Senior Laravel Developer" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Job Code <span class="text-danger">*</span></label>
                                <input type="text" name="job_code" class="form-control" placeholder="REQ-001" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Company <span class="text-danger">*</span></label>
                                <select name="company_id" id="company_id" class="form-select" required>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->company_id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department <span class="text-danger">*</span></label>
                                <select name="department" id="department_id" class="form-select" required>
                                    <option value="">Select Department</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->department_id }}">{{ $dept->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description" class="form-control" rows="2" placeholder="Brief summary of the role..."></textarea>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Long Description (Detailed JD)</label>
                            <textarea name="long_description" class="form-control" rows="8" placeholder="Detailed job description, responsibilities, and requirements..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="card form-card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h6 class="section-title">Requirements & Perks</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Minimum Experience (Years)</label>
                                <input type="number" name="minimum_experience" class="form-control" placeholder="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Maximum Experience (Years)</label>
                                <input type="number" name="maximum_experience" class="form-control" placeholder="10+">
                            </div>
                        </div>
                        <div class="row g-3 mb-0">
                            <div class="col-md-6">
                                <label class="form-label">Job Location</label>
                                <input type="text" name="job_location" class="form-control" placeholder="e.g. Noida, India">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Priority</label>
                                <select name="priority" class="form-select">
                                    <option value="Low">Low</option>
                                    <option value="Medium" selected>Medium</option>
                                    <option value="High">High</option>
                                    <option value="Urgent">Urgent</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings -->
            <div class="col-lg-4">
                <div class="card form-card shadow-sm border-0 mb-4 sticky-top" style="top: 1rem;">
                    <div class="card-body p-4">
                        <h6 class="section-title">Publishing Settings</h6>
                        
                        <div class="mb-4">
                            <label class="form-label">Job Type <span class="text-danger">*</span></label>
                            <select name="job_type" class="form-select" required>
                                @foreach($job_types as $type)
                                    <option value="{{ $type->job_type_id }}">{{ $type->type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">No. of Vacancies <span class="text-danger">*</span></label>
                            <input type="number" name="job_vacancy" class="form-control" value="1" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Closing Date</label>
                            <input type="date" name="date_of_closing" class="form-control">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1">Published</option>
                                <option value="2">Draft / Unpublished</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch p-0 ps-5">
                                <input class="form-check-input ms-n5" type="checkbox" name="show_on_website" value="yes" id="websiteSwitch" checked>
                                <label class="form-check-label ps-2" for="websiteSwitch">Show on Website</label>
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 shadow-sm">
                                <i class="bi bi-cloud-upload me-2"></i>Publish Job Opening
                            </button>
                            <a href="{{ route('jobs.index') }}" class="btn btn-light rounded-pill py-2">
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
        // Dynamic Cascading for Departments if needed
        $('#company_id').on('change', function() {
            var companyId = $(this).val();
            if(companyId) {
                $.ajax({
                    url: '/get-departments/' + companyId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#department_id').empty().append('<option value="">Select Department</option>');
                        $.each(data, function(key, value) {
                            $('#department_id').append('<option value="'+ value.department_id +'">'+ value.department_name +'</option>');
                        });
                    }
                });
            }
        });
    });
</script>
@endpush
