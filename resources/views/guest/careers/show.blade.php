@extends('layouts.careers')

@push('styles')
<style>
    [data-theme="dark"] .breadcrumb-item { color: var(--text-muted); }
    [data-theme="dark"] .breadcrumb-item.active { color: var(--text-main) !important; }
    [data-theme="dark"] .breadcrumb-item a { color: var(--accent); }
    [data-theme="dark"] .breadcrumb-item + .breadcrumb-item::before { color: var(--text-muted); }
    [data-theme="dark"] .job-content p,
    [data-theme="dark"] .job-content li,
    [data-theme="dark"] .job-content ul { color: var(--text-muted); }
    [data-theme="dark"] .border-primary { border-color: rgba(79, 70, 229, 0.3) !important; }
    [data-theme="dark"] .text-primary { color: #818cf8 !important; }
    [data-theme="dark"] small a.text-decoration-none { color: #818cf8; }
    .breadcrumb-item.active { color: var(--text-main); }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row g-5">
        <!-- Job Details Column -->
        <div class="col-lg-7">
            <div class="mb-4">
                <a href="{{ route('careers.index') }}" class="btn btn-light rounded-pill btn-sm mb-3">
                    <i class="bi bi-arrow-left me-1"></i> All Openings
                </a>
                <h1 class="fw-extrabold mb-2">{{ $job->job_title }}</h1>
                <div class="d-flex flex-wrap gap-3 text-muted">
                    <span><i class="bi bi-building me-1"></i> {{ $job->company_name ?? 'i2u2 Group' }}</span>
                    <span><i class="bi bi-diagram-3 me-1"></i> {{ $job->department_name ?? 'General' }}</span>
                    <span><i class="bi bi-clock me-1"></i> {{ $job->job_type == 1 ? 'Full-Time' : 'Contract' }}</span>
                </div>
            </div>

            <div class="glass-card p-4 mb-4">
                <h5 class="fw-bold mb-4">Job Description</h5>
                <div class="job-content text-muted lh-lg">
                    {!! $job->long_description !!}
                </div>
            </div>

            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Key Responsibilities & Requirements</h5>
                <div class="job-content text-muted lh-lg">
                    {!! $job->short_description !!}
                </div>
            </div>
        </div>

        <!-- Application Form Column -->
        <div class="col-lg-5">
            <div class="sticky-top" style="top: 100px;">
                <div class="glass-card p-4 shadow-lg border-primary border-opacity-25">
                    <h4 class="fw-bold mb-1">Apply for this Position</h4>
                    <p class="text-muted small mb-4">Submit your profile and our team will get back to you.</p>

                    @if(session('success'))
                        <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('careers.apply', $job->job_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="candidate_name" class="form-control" placeholder="e.g. John Doe" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Contact No. <span class="text-danger">*</span></label>
                                <input type="text" name="contact_no" class="form-control" placeholder="+91..." required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Experience (Years)</label>
                                <input type="number" name="experience" class="form-control" step="0.5" placeholder="e.g. 5">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Notice Period (Days)</label>
                                <input type="number" name="notice_period" class="form-control" placeholder="e.g. 30">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Upload Resume <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="file" name="job_resume" class="form-control" id="resumeUpload" required>
                                <label class="input-group-text bg-white border-start-0" for="resumeUpload"><i class="bi bi-file-earmark-pdf"></i></label>
                            </div>
                            <small class="text-muted">Accepted formats: PDF, DOCX (Max 5MB)</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 shadow-sm rounded-pill">
                            Submit Application
                        </button>

                        <p class="text-muted text-center mt-3 small">
                            By applying, you agree to our <a href="#" class="text-decoration-none">Privacy Policy</a> and <a href="#" class="text-decoration-none">Terms</a>.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
