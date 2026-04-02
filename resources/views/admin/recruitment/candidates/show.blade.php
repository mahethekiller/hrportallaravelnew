@extends('layouts.admin')

@section('title', $candidate->candidate_name . ' | Candidate Profile')

@push('styles')
<style>
    .profile-header {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        color: var(--text-main);
    }
    .profile-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 15px;
        transition: all 0.3s ease;
        color: var(--text-main);
    }
    .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 20px;
        border: 4px solid var(--accent);
        box-shadow: var(--glass-shadow);
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.8rem;
        border-radius: 30px;
        font-weight: 600;
        letter-spacing: 0.05em;
    }
    .info-label { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.2rem; }
    .info-value { font-size: 1rem; color: var(--text-main); font-weight: 500; }

    .timeline-item { position: relative; padding-left: 2rem; border-left: 2px dashed var(--glass-border); margin-left: 1rem; margin-bottom: 1.5rem; }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -11px;
        top: 0;
        width: 20px;
        height: 20px;
        background: var(--accent);
        border: 4px solid var(--glass-bg);
        border-radius: 50%;
    }

    [data-theme="dark"] .bg-primary-subtle { background-color: rgba(79, 70, 229, 0.15) !important; color: #818cf8 !important; }
    [data-theme="dark"] .bg-info-subtle { background-color: rgba(6, 182, 212, 0.15) !important; color: #22d3ee !important; }
    [data-theme="dark"] .bg-light { background-color: rgba(255, 255, 255, 0.05) !important; color: var(--text-main) !important; border: 1px solid var(--glass-border) !important; }
    [data-theme="dark"] .btn-light { background-color: rgba(255, 255, 255, 0.05); color: var(--text-main); border: 1px solid var(--glass-border); }
    [data-theme="dark"] .btn-outline-primary { border-color: var(--accent); color: var(--accent); }
    [data-theme="dark"] .btn-outline-danger { border-color: #ef4444; color: #ef4444; }
    [data-theme="dark"] .italic { color: #94a3b8 !important; }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <!-- Header Section -->
    <div class="profile-header p-4 mb-4 shadow-sm">
        <div class="row align-items-center">
            <div class="col-auto">
                @if($candidate->profile_picture)
                    <img src="{{ asset('storage/profiles/' . $candidate->profile_picture) }}" class="profile-img" alt="Profile">
                @else
                    <div class="profile-img bg-primary-subtle d-flex align-items-center justify-content-center">
                        <span class="display-3 fw-bold text-primary">{{ substr($candidate->candidate_name, 0, 1) }}</span>
                    </div>
                @endif
            </div>
            <div class="col">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <h2 class="fw-bold mb-0">{{ $candidate->candidate_name }}</h2>
                    <span class="status-badge bg-primary-subtle text-primary border border-primary-subtle">
                        {{ $candidate->application_status }}
                    </span>
                </div>
                <p class="text-muted mb-3"><i class="bi bi-briefcase me-2"></i>{{ $candidate->job_title }} ({{ $candidate->post_code }})</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="mailto:{{ $candidate->email }}" class="btn btn-light rounded-pill btn-sm"><i class="bi bi-envelope me-2"></i>{{ $candidate->email }}</a>
                    @if($candidate->contact_no)
                        <a href="tel:{{ $candidate->contact_no }}" class="btn btn-light rounded-pill btn-sm"><i class="bi bi-telephone me-2"></i>{{ $candidate->contact_no }}</a>
                    @endif
                    @if($candidate->job_resume)
                        <a href="{{ asset('storage/resume/' . $candidate->job_resume) }}" download class="btn btn-primary rounded-pill btn-sm"><i class="bi bi-download me-2"></i>Download Resume</a>
                    @endif
                </div>
            </div>
            <div class="col-lg-auto mt-4 mt-lg-0">
                <div class="d-flex flex-column gap-2">
                    <form action="{{ route('candidates.convert', $candidate->application_id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success rounded-pill w-100 shadow-sm">
                            <i class="bi bi-person-check me-2"></i>Convert to Employee
                        </button>
                    </form>
                    <div class="d-flex gap-2">
                        <a href="{{ route('candidates.edit', $candidate->application_id) }}" class="btn btn-outline-primary rounded-pill flex-fill">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </a>
                        <button type="button" class="btn btn-outline-danger rounded-pill flex-fill" onclick="if(confirm('Archive this candidate?')) document.getElementById('delete-form').submit()">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <form id="delete-form" action="{{ route('candidates.destroy', $candidate->application_id) }}" method="POST" class="d-none">
                        @csrf @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Experience & Compensation -->
            <div class="card profile-card mb-4 border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4"><i class="bi bi-cash-stack me-2 text-primary"></i>Experience & Expectations</h6>
                    <div class="row g-4">
                        <div class="col-md-3">
                            <p class="info-label">Experience</p>
                            <p class="info-value">{{ $candidate->experience ?? '0' }} Years</p>
                        </div>
                        <div class="col-md-3">
                            <p class="info-label">Current CTC</p>
                            <p class="info-value">₹ {{ $candidate->current_package ?? 'N/A' }} LPA</p>
                        </div>
                        <div class="col-md-3">
                            <p class="info-label">Expected CTC</p>
                            <p class="info-value">₹ {{ $candidate->expected_package ?? 'N/A' }} LPA</p>
                        </div>
                        <div class="col-md-3">
                            <p class="info-label">Notice Period</p>
                            <p class="info-value">{{ $candidate->notice_period ?? '0' }} Days</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Interviews Timeline -->
            <div class="card profile-card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4"><i class="bi bi-calendar-check me-2 text-primary"></i>Interview History</h6>
                    @if($interviews->count() > 0)
                        @foreach($interviews as $int)
                            <div class="timeline-item">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-0">{{ $int->interview_mode }} Round</h6>
                                        <small class="text-muted">{{ date('d M, Y', strtotime($int->interview_date)) }} at {{ $int->interview_time }}</small>
                                    </div>
                                    <span class="status-badge bg-info-subtle text-info border border-info-subtle">{{ ucfirst($int->status) }}</span>
                                </div>
                                <p class="text-muted small mb-0">{{ $int->description }}</p>
                                @if($int->remarks)
                                    <div class="mt-2 p-2 bg-light rounded italic small border-start border-4 border-primary">
                                        "{{ $int->remarks }}"
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x display-4 text-muted"></i>
                            <p class="text-muted mt-2">No interviews scheduled yet.</p>
                            <a href="{{ route('interviews.create', ['application_id' => $candidate->application_id]) }}" class="btn btn-primary rounded-pill btn-sm">Schedule Now</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card profile-card mb-4 border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4"><i class="bi bi-info-circle me-2 text-primary"></i>Source Info</h6>
                    <div class="mb-4">
                        <p class="info-label">Application Source</p>
                        <p class="info-value">{{ $candidate->source }} @if($candidate->sub_source) ({{ $candidate->sub_source }}) @endif</p>
                    </div>
                    @if($candidate->referral_name)
                    <div class="mb-4">
                        <p class="info-label">Referral</p>
                        <p class="info-value">{{ $candidate->referral_name }}</p>
                    </div>
                    @endif
                    <div class="mb-0">
                        <p class="info-label">Applied On</p>
                        <p class="info-value">{{ date('d M, Y', strtotime($candidate->legacy_created_at)) }}</p>
                    </div>
                </div>
            </div>

            <div class="card profile-card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-chat-left-dots me-2 text-primary"></i>Internal Remarks</h6>
                    <p class="text-muted small">
                        {{ $candidate->hr_remarks ?? $candidate->application_remarks ?? 'No screening notes provided.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
