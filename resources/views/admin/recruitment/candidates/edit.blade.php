@extends('layouts.admin')

@section('title', 'Edit Candidate: ' . $candidate->candidate_name . ' | i2u2 2.0')

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
    #profile_preview { position: absolute; width: 100%; height: 100%; object-fit: cover; }
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
        <h4 class="fw-bold mb-1"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Candidate Details</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('candidates.index') }}" class="text-decoration-none">Recruitment</a></li>
                <li class="breadcrumb-item"><a href="{{ route('candidates.show', $candidate->application_id) }}" class="text-decoration-none">Profile</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('candidates.update', $candidate->application_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card form-card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="profile-upload me-4" onclick="document.getElementById('profile_input').click()">
                                @if($candidate->profile_picture)
                                    <img id="profile_preview" src="{{ asset('storage/profiles/' . $candidate->profile_picture) }}" alt="Preview">
                                @else
                                    <i class="bi bi-camera" id="upload_icon"></i>
                                    <img id="profile_preview" style="display:none" alt="Preview">
                                @endif
                                <input type="file" name="profile_picture" id="profile_input" hidden onchange="previewImage(this)">
                            </div>
                            <div>
                                <h6 class="section-title mb-1">Update Profile</h6>
                                <p class="text-muted small mb-0">Change the professional photo for this candidate.</p>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="candidate_name" class="form-control" value="{{ $candidate->candidate_name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ $candidate->email }}" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="contact_no" class="form-control" value="{{ $candidate->contact_no }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="Male" {{ $candidate->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $candidate->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ $candidate->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-0">
                            <div class="col-md-12">
                                <label class="form-label">Current Location</label>
                                <input type="text" name="current_location" class="form-control" value="{{ $candidate->current_location }}">
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
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->job_id }}" {{ $candidate->job_id == $job->job_id ? 'selected' : '' }}>{{ $job->job_title }} ({{ $job->job_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Source of Application</label>
                                <select name="source" class="form-select">
                                    <option value="Linkedin" {{ $candidate->source == 'Linkedin' ? 'selected' : '' }}>Linkedin</option>
                                    <option value="Naukri" {{ $candidate->source == 'Naukri' ? 'selected' : '' }}>Naukri.com</option>
                                    <option value="Referral" {{ $candidate->source == 'Referral' ? 'selected' : '' }}>Referral</option>
                                    <option value="Website" {{ $candidate->source == 'Website' ? 'selected' : '' }}>Direct Website</option>
                                    <option value="Other" {{ $candidate->source == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Update Resume (PDF/DOCX)</label>
                            <input type="file" name="job_resume" class="form-control">
                            @if($candidate->job_resume)
                                <small class="text-muted mt-2 d-block">Current: <a href="{{ asset('storage/resumes/' . $candidate->job_resume) }}" target="_blank">{{ $candidate->job_resume }}</a></small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card form-card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h6 class="section-title">Experience & Logistics</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Current CTC (LPA)</label>
                                <input type="text" name="current_package" class="form-control" value="{{ $candidate->current_package }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Expected CTC (LPA)</label>
                                <input type="text" name="expected_package" class="form-control" value="{{ $candidate->expected_package }}">
                            </div>
                        </div>
                        <div class="row g-3 mb-0">
                            <div class="col-md-6">
                                <label class="form-label">Notice Period (Days)</label>
                                <input type="number" name="notice_period" class="form-control" value="{{ $candidate->notice_period }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Total Experience (Years)</label>
                                <input type="text" name="experience" class="form-control" value="{{ $candidate->experience }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card form-card shadow-sm border-0 mb-4 sticky-top" style="top: 1rem;">
                    <div class="card-body p-4">
                        <h6 class="section-title">Application Status</h6>
                        
                        <div class="mb-4">
                            <label class="form-label">Current Status</label>
                            <select name="application_status" class="form-select">
                                <option value="Applied" {{ $candidate->application_status == 'Applied' ? 'selected' : '' }}>Applied</option>
                                <option value="Shortlisted" {{ $candidate->application_status == 'Shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                <option value="Interviewing" {{ $candidate->application_status == 'Interviewing' ? 'selected' : '' }}>Interviewing</option>
                                <option value="Offered" {{ $candidate->application_status == 'Offered' ? 'selected' : '' }}>Offered</option>
                                <option value="Joined" {{ $candidate->application_status == 'Joined' ? 'selected' : '' }}>Joined</option>
                                <option value="Rejected" {{ $candidate->application_status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Application Remarks</label>
                            <textarea name="application_remarks" class="form-control" rows="4">{{ $candidate->application_remarks }}</textarea>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 shadow-sm">
                                <i class="bi bi-save me-2"></i>Update Candidate
                            </button>
                            <a href="{{ route('candidates.show', $candidate->application_id) }}" class="btn btn-light rounded-pill py-2">
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
                $('#profile_preview').attr('src', e.target.result).show();
                $('#upload_icon').hide();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
