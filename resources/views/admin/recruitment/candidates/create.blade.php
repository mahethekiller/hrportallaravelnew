@extends('layouts.admin')

@section('title', 'Add Candidate | i2u2 2.0')

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
    .profile-upload {
        width: 120px;
        height: 120px;
        border: 2px dashed var(--glass-border);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .profile-upload:hover { border-color: var(--accent); background: rgba(99, 102, 241, 0.05); }
    .profile-upload i { font-size: 2rem; color: var(--text-muted); }
    #profile_preview { position: absolute; width: 100%; height: 100%; object-fit: cover; display: none; }
    [data-theme="dark"] .btn-light {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        color: var(--text-main);
    }
    [data-theme="dark"] .btn-outline-primary { border-color: var(--accent); color: var(--accent); }
    [data-theme="dark"] .btn-check:checked + .btn-outline-primary { background-color: var(--accent); color: #fff; }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <div class="mb-4">
        <h4 class="fw-bold mb-1"><i class="bi bi-person-plus me-2 text-primary"></i>Add New Candidate</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('candidates.index') }}" class="text-decoration-none">Recruitment</a></li>
                <li class="breadcrumb-item active">Add Candidate</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('candidates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card form-card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="profile-upload me-4" onclick="document.getElementById('profile_input').click()">
                                <i class="bi bi-camera"></i>
                                <img id="profile_preview" alt="Preview">
                                <input type="file" name="profile_picture" id="profile_input" hidden onchange="previewImage(this)">
                            </div>
                            <div>
                                <h6 class="section-title mb-1">Candidate Profile</h6>
                                <p class="text-muted small mb-0">Upload a professional photo for the talent card.</p>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="candidate_name" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="contact_no" class="form-control" placeholder="+91 XXX XXX XXXX">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-0">
                            <div class="col-md-12">
                                <label class="form-label">Current Location</label>
                                <input type="text" name="current_location" class="form-control" placeholder="City, Country">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card form-card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h6 class="section-title">Application Details</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Applying For Position <span class="text-danger">*</span></label>
                                <select name="job_id" class="form-select" required>
                                    <option value="">Select Job</option>
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->job_id }}">{{ $job->job_title }} ({{ $job->job_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Source of Application</label>
                                <select name="source" class="form-select">
                                    <option value="Linkedin">Linkedin</option>
                                    <option value="Naukri">Naukri.com</option>
                                    <option value="Referral">Referral</option>
                                    <option value="Website">Direct Website</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Upload Resume (PDF/DOCX) <span class="text-danger">*</span></label>
                            <input type="file" name="job_resume" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="card form-card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h6 class="section-title">Experience & Logistics</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Current CTC (LPA)</label>
                                <input type="text" name="current_package" class="form-control" placeholder="e.g. 8.5">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Expected CTC (LPA)</label>
                                <input type="text" name="expected_package" class="form-control" placeholder="e.g. 12.0">
                            </div>
                        </div>
                        <div class="row g-3 mb-0">
                            <div class="col-md-6">
                                <label class="form-label">Notice Period (Days)</label>
                                <input type="number" name="notice_period" class="form-control" placeholder="e.g. 30">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Total Experience (Years)</label>
                                <input type="text" name="experience" class="form-control" placeholder="e.g. 5.5">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card form-card shadow-sm border-0 mb-4 sticky-top" style="top: 1rem;">
                    <div class="card-body p-4">
                        <h6 class="section-title">Submission</h6>
                        
                        <div class="mb-4">
                            <label class="form-label">Application Remarks</label>
                            <textarea name="application_remarks" class="form-control" rows="4" placeholder="Initial screening notes..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">HR Score / Rating</label>
                            <div class="d-flex gap-2">
                                @for($i=1; $i<=5; $i++)
                                    <div class="form-check p-0">
                                        <input type="radio" name="hr_rating" value="{{ $i }}" class="btn-check" id="btn-check-{{ $i }}">
                                        <label class="btn btn-outline-primary rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;" for="btn-check-{{ $i }}">{{ $i }}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 shadow-sm">
                                <i class="bi bi-person-check me-2"></i>Add to Pipeline
                            </button>
                            <a href="{{ route('candidates.index') }}" class="btn btn-light rounded-pill py-2">
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
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#profile_preview').attr('src', e.target.result).fadeIn();
                $('.profile-upload i').fadeOut();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
