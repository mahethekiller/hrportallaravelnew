@extends('layouts.admin')

@section('title', 'Job Requests | i2u2 2.0')

@push('styles')
<style>
    .request-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 15px;
        transition: all 0.3s ease;
        color: var(--text-main);
    }
    .request-card:hover { transform: translateY(-5px); border-color: var(--accent); }
    
    .status-pending { background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); }
    .status-approved { background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
    .status-rejected { background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }
    
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
            <h4 class="fw-bold mb-1"><i class="bi bi-file-earmark-plus me-2 text-primary"></i>Job Requests</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Recruitment</a></li>
                    <li class="breadcrumb-item active">Requests</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('requests.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> New Request
            </a>
        </div>
    </div>

    <div class="card request-card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="requestsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Requested Position</th>
                            <th class="py-3 text-center">Vacancies</th>
                            <th class="py-3">Company & Dept</th>
                            <th class="py-3">Requested By</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $request->post_name }}</div>
                                <small class="text-muted">Requested: {{ \Carbon\Carbon::parse($request->added_date)->format('d M, Y') }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3">{{ $request->vacancies }}</span>
                            </td>
                            <td>
                                <div class="small fw-semibold">{{ $request->company_name ?? 'i2u2 Group' }}</div>
                                <small class="text-muted">{{ $request->department_name ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <div class="small fw-bold">{{ $request->first_name }} {{ $request->last_name }}</div>
                                <small class="text-muted">Manager</small>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusClass = 'status-pending';
                                    $statusText = 'Pending';
                                    if($request->approve_status == 1) { $statusClass = 'status-approved'; $statusText = 'Approved'; }
                                    if($request->approve_status == 2) { $statusClass = 'status-rejected'; $statusText = 'Rejected'; }
                                @endphp
                                <span class="badge {{ $statusClass }} rounded-pill px-3 py-2">
                                    {{ $statusText }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle border shadow-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i> View Details</a></li>
                                        @if($request->approve_status == 0)
                                        <li>
                                            <form action="{{ route('requests.approve', $request->request_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-success"><i class="bi bi-check-circle me-2"></i> Approve Request</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('requests.reject', $request->request_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-x-circle me-2"></i> Reject Request</button>
                                            </form>
                                        </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="{{ route('requests.edit', $request->request_id) }}"><i class="bi bi-pencil me-2"></i> Edit Request</a></li>
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
        $('#requestsTable').DataTable({
            "pageLength": 10,
            "order": [[0, "asc"]],
            "language": {
                "search": "<i class='bi bi-search me-1'></i>",
                "searchPlaceholder": "Search requests..."
            },
            "dom": '<"d-flex justify-content-between align-items-center p-3"<"fw-bold"l><"d-flex gap-2"f>>rt<"d-flex justify-content-between align-items-center p-3"ip>'
        });
    });
</script>
@endpush
