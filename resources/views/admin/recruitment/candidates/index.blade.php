@extends('layouts.admin')

@section('title', 'Candidate Hub | i2u2 2.0')

@push('styles')
<style>
    .candidate-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 15px;
        transition: all 0.3s ease;
        color: var(--text-main);
    }
    .candidate-card:hover {
        transform: translateY(-5px);
        border-color: var(--accent);
    }
    .badge-applied { background: rgba(99, 102, 241, 0.15); color: #6366f1; border: 1px solid rgba(99, 102, 241, 0.2); }
    .badge-interview { background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); }
    .badge-selected { background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
    .badge-rejected { background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }

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
            <h4 class="fw-bold mb-1"><i class="bi bi-person-badge me-2 text-primary"></i>Candidate Hub</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Recruitment</a></li>
                    <li class="breadcrumb-item active">Candidates</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('candidates.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Add Candidate
            </a>
        </div>
    </div>

    <div class="card candidate-card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="candidatesTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Candidate</th>
                            <th class="py-3">Position Applied</th>
                            <th class="py-3">Contact</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Applied Date</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidates as $candidate)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($candidate->candidate_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $candidate->candidate_name }}</div>
                                        <small class="text-muted">{{ $candidate->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-primary">{{ $candidate->job_title ?? 'Unknown' }}</div>
                                <small class="text-muted">Code: {{ $candidate->post_code ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <div class="small">{{ $candidate->contact_no ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $candidate->current_location ?? 'India' }}</small>
                            </td>
                            <td>
                                @php
                                    $statusClass = 'badge-applied';
                                    if(stripos($candidate->application_status, 'Interview') !== false) $statusClass = 'badge-interview';
                                    if(stripos($candidate->application_status, 'Selected') !== false) $statusClass = 'badge-selected';
                                    if(stripos($candidate->application_status, 'Rejected') !== false) $statusClass = 'badge-rejected';
                                @endphp
                                <span class="badge {{ $statusClass }} rounded-pill px-3 py-2">
                                    {{ $candidate->application_status }}
                                </span>
                            </td>
                            <td>
                                <div class="small fw-semibold">{{ \Carbon\Carbon::parse($candidate->legacy_created_at ?? $candidate->created_at)->format('d M, Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($candidate->legacy_created_at ?? $candidate->created_at)->diffForHumans() }}</small>
                            </td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle border shadow-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3">
                                        <li><a class="dropdown-item" href="{{ route('candidates.show', $candidate->application_id) }}"><i class="bi bi-eye me-2"></i> View Profile</a></li>
                                        @if($candidate->job_resume)
                                        <li><a class="dropdown-item" href="{{ asset('storage/resume/' . $candidate->job_resume) }}" download><i class="bi bi-download me-2"></i> Download Resume</a></li>
                                        @endif
                                        <li><a class="dropdown-item" href="{{ route('interviews.create', ['application_id' => $candidate->application_id]) }}"><i class="bi bi-calendar-check me-2"></i> Schedule Interview</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('candidates.destroy', $candidate->application_id) }}" method="POST" onsubmit="return confirm('Archive this candidate?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i> Archive</button>
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
        $('#candidatesTable').DataTable({
            "pageLength": 10,
            "order": [[4, "desc"]],
            "language": {
                "search": "<i class='bi bi-search me-1'></i>",
                "searchPlaceholder": "Search candidates..."
            },
            "dom": '<"d-flex justify-content-between align-items-center p-3"<"fw-bold"l><"d-flex gap-2"f>>rt<"d-flex justify-content-between align-items-center p-3"ip>'
        });
    });
</script>
@endpush
