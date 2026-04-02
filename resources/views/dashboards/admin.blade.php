@extends('layouts.admin')

@section('page_title', 'Admin Overview')

@section('content')
<div class="row g-4 mb-4">
    <!-- Super Admin KPI Widgets -->
    <div class="col-md-3">
        <div class="glass-card text-center p-4">
            <div class="text-primary mb-2"><i class="bi bi-buildings fs-1"></i></div>
            <h2 class="fw-bold mb-0">{{ \App\Models\Company::count() }}</h2>
            <div class="text-muted small fw-semibold text-uppercase tracking-wide">Total Companies</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card text-center p-4">
            <div class="text-success mb-2"><i class="bi bi-people fs-1"></i></div>
            <h2 class="fw-bold mb-0">{{ \App\Models\Employee::count() }}</h2>
            <div class="text-muted small fw-semibold text-uppercase tracking-wide">Total Employees</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card text-center p-4">
            <div class="text-warning mb-2"><i class="bi bi-diagram-3 fs-1"></i></div>
            <h2 class="fw-bold mb-0">{{ \App\Models\Department::count() }}</h2>
            <div class="text-muted small fw-semibold text-uppercase tracking-wide">Departments</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card text-center p-4">
            <div class="text-info mb-2"><i class="bi bi-shield-check fs-1"></i></div>
            <h2 class="fw-bold mb-0">{{ \Spatie\Permission\Models\Role::count() }}</h2>
            <div class="text-muted small fw-semibold text-uppercase tracking-wide">Active Roles</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="glass-card pb-5">
            <h4 class="fw-bold mb-3">System Administration</h4>
            <p class="text-muted">Welcome to the Super Admin hub. You have global read/write access to all HR modules. Use the sidebar to configure the organizational structure.</p>
        </div>
    </div>
</div>
@endsection
