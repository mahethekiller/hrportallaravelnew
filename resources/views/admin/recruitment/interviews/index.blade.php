@extends('layouts.admin')

@section('title', 'Interview Pipeline | i2u2 2.0')

@push('styles')
<style>
    .interview-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        transition: all 0.3s ease;
        color: var(--text-main);
    }
    .interview-card:hover { transform: translateY(-5px); border-color: var(--accent); }
    .status-badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.7rem;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    [data-theme="dark"] .bg-success-subtle { background-color: rgba(16, 185, 129, 0.15) !important; color: #10b981 !important; border: 1px solid rgba(16, 185, 129, 0.2); }
    [data-theme="dark"] .bg-warning-subtle { background-color: rgba(245, 158, 11, 0.15) !important; color: #f59e0b !important; border: 1px solid rgba(245, 158, 11, 0.2); }
    [data-theme="dark"] .bg-primary-subtle { background-color: rgba(79, 70, 229, 0.15) !important; color: #818cf8 !important; }
    [data-theme="dark"] .border-top { border-color: var(--border-muted) !important; }
    [data-theme="dark"] .btn-light { background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: var(--text-main); }
    [data-theme="dark"] .btn-light:hover { background: rgba(255,255,255,0.1); }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-calendar-check me-2 text-primary"></i>Interview Pipeline</h4>
            <p class="text-muted small mb-0">Track and manage all scheduled candidate assessments.</p>
        </div>
        <a href="{{ route('interviews.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>Schedule Interview
        </a>
    </div>

    <div class="row g-4">
        @forelse($interviews as $int)
        <div class="col-xl-4 col-md-6">
            <div class="card interview-card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar-xs bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 35px; height: 35px;">
                                {{ strtoupper(substr($int->candidate_name ?? 'C', 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">{{ $int->candidate_name ?? 'Unknown' }}</h6>
                                <div class="text-muted" style="font-size: 0.75rem;">{{ $int->candidate_email }}</div>
                            </div>
                        </div>
                        <span class="status-badge {{ $int->status == 'confirmed' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} border">
                            {{ ucfirst($int->status) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <div class="fw-bold text-primary mb-1"><i class="bi bi-briefcase me-2"></i>{{ $int->job_title }}</div>
                        <div class="text-muted small mb-1"><i class="bi bi-calendar-event me-2"></i>{{ date('d M, Y', strtotime($int->interview_date)) }}</div>
                        <div class="text-muted small"><i class="bi bi-clock me-2"></i>{{ $int->interview_time }} ({{ $int->interview_mode }})</div>
                    </div>

                    <div class="mt-auto d-flex justify-content-between align-items-center pt-3 border-top border-light">
                        <div class="text-muted small">Panel: {{ count(explode(',', $int->interviewers_id)) }} Members</div>
                        <div class="d-flex gap-2">
                            @if($int->status === 'selected' && $int->application_id)
                            <form action="{{ route('candidates.convert', $int->application_id) }}" method="POST"
                                  onsubmit="return confirm('Convert {{ $int->candidate_name ?? 'this candidate' }} to an Employee?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" title="Convert to Employee">
                                    <i class="bi bi-person-check me-1"></i> Convert
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('interviews.edit', $int->job_interview_id) }}" class="btn btn-sm btn-light rounded-circle" title="Edit Schedule">
                                <i class="bi bi-pencil text-primary"></i>
                            </a>
                            <form action="{{ route('interviews.destroy', $int->job_interview_id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light rounded-circle" onclick="return confirm('Cancel this interview?')" title="Cancel">
                                    <i class="bi bi-trash text-danger"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm p-5 text-center text-muted glass-bg">
                <i class="bi bi-calendar-x display-1 mb-3 opacity-25"></i>
                <h5>No interviews scheduled</h5>
                <p>Start by scheduling an interview for an active candidate.</p>
                <div class="mt-3">
                    <a href="{{ route('interviews.create') }}" class="btn btn-primary rounded-pill">Schedule Now</a>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
