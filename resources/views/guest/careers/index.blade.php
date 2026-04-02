@extends('layouts.careers')

@push('styles')
<style>
    [data-theme="dark"] .badge.bg-light {
        background-color: rgba(255,255,255,0.08) !important;
        color: var(--text-muted) !important;
        border-color: rgba(255,255,255,0.1) !important;
    }
    [data-theme="dark"] .card { background: var(--glass-bg); color: var(--text-main); }
    [data-theme="dark"] .hero-section h1,
    [data-theme="dark"] .hero-section p { color: var(--text-main); }
    .form-select {
        background-color: var(--glass-bg);
        color: var(--text-main);
        border: 1px solid var(--glass-border);
    }
    [data-theme="dark"] .form-select {
        background-color: rgba(255, 255, 255, 0.04) !important;
        color: #f1f5f9 !important;
        border-color: rgba(255, 255, 255, 0.12) !important;
    }
    [data-theme="dark"] .form-select option {
        background-color: #0f172a;
        color: #f1f5f9;
    }
</style>
@endpush

@section('content')
<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-extrabold mb-3">Shape the Future with i2u2 Group</h1>
        <p class="text-muted lead mb-5">Explore modern career opportunities and grow with a world-class team of innovators.</p>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="glass-card p-3 d-flex gap-2">
                    <input type="text" class="form-control border-0 bg-transparent" placeholder="Search by job title, location, or keyword..." id="jobSearch">
                    <button class="btn btn-primary px-4">Find Jobs</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <!-- Filters row -->
    <div class="d-flex justify-content-between align-items-center mb-5 mt-4">
        <h4 class="fw-bold mb-0">{{ $jobs->count() }} Open Positions</h4>
        <div class="d-flex gap-3">
            <select class="form-select border-0 shadow-sm ps-3" style="width: 200px;">
                <option value="">All Departments</option>
                @php
                    $depts = $jobs->pluck('department_name')->unique();
                @endphp
                @foreach($depts as $dept)
                    <option value="{{ $dept }}">{{ $dept }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Job Grid -->
    <div class="row g-4" id="jobGrid">
        @forelse($jobs as $job)
        <div class="col-md-6 col-lg-4 job-item" data-dept="{{ $job->department_name }}">
            <div class="glass-card p-4 h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="p-3 rounded-4 bg-primary-subtle text-primary" style="background-color: rgba(79, 70, 229, 0.1) !important;">
                        <i class="bi bi-briefcase fs-4"></i>
                    </div>
                    <span class="badge bg-light text-muted border px-3 py-2 rounded-pill small">{{ $job->job_type == 1 ? 'Full-Time' : 'Contract' }}</span>
                </div>
                
                <h5 class="fw-bold mb-1">{{ $job->job_title }}</h5>
                <p class="text-muted small mb-4"><i class="bi bi-geo-alt me-1"></i>India | {{ $job->department_name ?? 'General' }}</p>
                
                <div class="mb-4 text-muted small" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ strip_tags($job->short_description) }}
                </div>
                
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <span class="fw-bold fs-6">REQ-{{ $job->job_id }}</span>
                    <a href="{{ route('careers.show', $job->job_id) }}" class="btn btn-outline-primary rounded-pill px-4 btn-sm">Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-search display-1 text-muted opacity-25"></i>
            <h5 class="mt-4 text-muted">No open positions matching your search at the moment.</h5>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#jobSearch').on('keyup', function() {
            const query = $(this).val().toLowerCase();
            $('.job-item').each(function() {
                const text = $(this).text().toLowerCase();
                $(this).toggle(text.includes(query));
            });
        });
        
        $('.form-select').on('change', function() {
            const dept = $(this).val();
            if(!dept) {
                $('.job-item').show();
            } else {
                $('.job-item').hide();
                $('.job-item[data-dept="' + dept + '"]').show();
            }
        });
    });
</script>
@endpush
