@extends('layouts.admin')

@section('title', 'Job Openings | i2u2 2.0')

@push('styles')
<style>
    .job-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 15px;
        transition: all 0.3s ease;
        color: var(--text-main);
    }
    .job-card:hover {
        transform: translateY(-5px);
        border-color: var(--accent);
    }
    .badge-published { background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
    .badge-unpublished { background: rgba(100, 116, 139, 0.15); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.2); }
    
    [data-theme="dark"] .table { color: var(--text-main) !important; }
    [data-theme="dark"] .table thead th { 
        background: var(--border-muted);
        color: var(--text-main);
        border-color: var(--border-muted);
    }
    [data-theme="dark"] .table td { border-color: rgba(255,255,255,0.05); color: var(--text-main); }
    [data-theme="dark"] .avatar-sm { background-color: rgba(255,255,255,0.05) !important; color: var(--accent) !important; }
    [data-theme="dark"] .dropdown-menu { background: var(--glass-bg); backdrop-filter: blur(10px); border: 1px solid var(--glass-border); shadow: var(--glass-shadow); }
    [data-theme="dark"] .dropdown-item { color: var(--text-main); }
    [data-theme="dark"] .dropdown-item:hover { background: rgba(255,255,255,0.05); }
    [data-theme="dark"] .dataTables_info, [data-theme="dark"] .dataTables_paginate { color: var(--text-muted) !important; }
    [data-theme="dark"] .page-link { background: var(--glass-bg); border-color: var(--glass-border); color: var(--text-main); }
    [data-theme="dark"] .page-item.active .page-link { background: var(--accent); border-color: var(--accent); }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-briefcase me-2 text-primary"></i>Job Openings</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Recruitment</a></li>
                    <li class="breadcrumb-item active">Openings</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('careers.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm" target="_blank">
                <i class="bi bi-box-arrow-up-right me-1"></i> Career Board
            </a>
            <a href="{{ route('jobs.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> New Job Post
            </a>
        </div>
    </div>

    <div class="card job-card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="jobsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Job Details</th>
                            <th class="py-3">Company & Dept</th>
                            <th class="py-3 text-center">Vacancies</th>
                            <th class="py-3 text-center">Candidates</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">
                                        <i class="bi bi-briefcase"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $job->job_title }}</div>
                                        <small class="text-muted">Code: {{ $job->job_code }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small fw-semibold">{{ $job->company_name ?? 'i2u2 Group' }}</div>
                                <small class="text-muted">{{ $job->department_name ?? 'General' }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3">{{ $job->job_vacancy }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('candidates.index', ['job_id' => $job->job_id]) }}" class="text-decoration-none">
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">
                                        {{ $job->candidate_count }} Applicants
                                    </span>
                                </a>
                            </td>
                            <td class="text-center">
                                @if($job->status == 1)
                                    <span class="badge badge-published rounded-pill px-3 py-2">Published</span>
                                @else
                                    <span class="badge badge-unpublished rounded-pill px-3 py-2">Unpublished</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle border shadow-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3">
                                        <li><a class="dropdown-item" href="{{ route('jobs.edit', $job->job_id) }}"><i class="bi bi-pencil me-2"></i> Edit Job</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i> View Page</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-files me-2"></i> Clone Role</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('jobs.destroy', $job->job_id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="bi bi-trash me-2"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#jobsTable').DataTable({
            "pageLength": 10,
            "order": [[1, "asc"]],
            "language": {
                "search": "<i class='bi bi-search me-1'></i>",
                "searchPlaceholder": "Search jobs..."
            },
            "dom": '<"d-flex justify-content-between align-items-center p-3"<"fw-bold"l><"d-flex gap-2"f>>rt<"d-flex justify-content-between align-items-center p-3"ip>'
        });
    });
</script>
@endpush
