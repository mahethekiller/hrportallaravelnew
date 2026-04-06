@extends('layouts.admin')

@section('page_title', 'Staff Directory')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
<style>
    .avatar-sm { width: 45px; height: 45px; object-fit: cover; border-radius: 50%; }
    .dt-buttons .btn { border-radius: 50px; padding: 5px 15px; font-size: 12px; margin-right: 5px; }
    .filter-card { 
        background: var(--glass-bg); 
        backdrop-filter: blur(10px); 
        border: 1px solid var(--glass-border); 
        border-radius: 15px; 
    }
    [data-theme="dark"] .filter-card .form-label {
        color: var(--text-main) !important;
        opacity: 0.9;
    }
    [data-theme="dark"] .filter-card .form-select {
        border: 1px solid var(--border-muted) !important;
        background-color: rgba(255,255,255,0.03) !important;
        color: var(--text-main) !important;
    }
    [data-theme="dark"] .dt-buttons .btn { border: 1px solid var(--border-muted); }
</style>
@endpush

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1">Employee Directory</h4>
        <p class="text-muted mb-0 small">Comprehensive personnel records and organizational tracking.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        @can('manage_employees')
        <button class="btn btn-primary shadow-sm rounded-pill px-4" onclick="createEmployee()">
            <i class="bi bi-person-plus me-1"></i> Add New Employee
        </button>
        @endcan
    </div>
</div>

<!-- Filter Bar -->
<div class="filter-card p-3 mb-4 shadow-sm">
    <div class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label small fw-bold text-muted text-uppercase">Filter by Company</label>
            <select class="form-select form-select-sm shadow-sm" id="filter_company">
                <option value="">All Companies</option>
                @foreach($companies as $company)
                    <option value="{{ $company->company_id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-bold text-muted text-uppercase">Filter by Manager</label>
            <select class="form-select form-select-sm shadow-sm" id="filter_manager">
                <option value="">All Managers</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->user_id }}">{{ $manager->first_name }} {{ $manager->last_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-bold text-muted text-uppercase">Account Status</label>
            <select class="form-select form-select-sm shadow-sm" id="filter_status">
                <option value="">All Status</option>
                <option value="1" selected>Active</option>
                <option value="2">Terminated</option>
                <option value="3">Left</option>
                <option value="4">Abscond</option>
                <option value="5">Disable</option>
                <option value="0">Resigned</option>
            </select>
        </div>
        <div class="col-md-2 text-end text-md-start">
            <button class="btn btn-sm btn-light rounded-pill px-3 w-100" onclick="resetFilters()">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
            </button>
        </div>
    </div>
</div>

<div class="glass-card p-0 overflow-hidden shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 w-100" id="employeesTable">
            <thead class="bg-light text-muted small text-uppercase">
                <tr>
                    <th class="ps-4">Employee</th>
                    <th>Contact & Role</th>
                    <th>Organization</th>
                    <th>Manager</th>
                    <th>Personal</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Employee Modal (Shared for Create/Edit) -->
@include('admin.employees.partials.modal')

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let table;
    
    $(document).ready(function() {
        table = $('#employeesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('employees.index') }}",
                data: function(d) {
                    d.filter_company = $('#filter_company').val();
                    d.filter_manager = $('#filter_manager').val();
                    d.filter_status = $('#filter_status').val();
                }
            },
            order: [[0, 'desc']],
            dom: '<"d-flex justify-content-between align-items-center p-3"<"dt-btn-container"B><"dt-search-container"f>>t<"d-flex justify-content-between align-items-center p-3"ip>',
            buttons: [
                { extend: 'excel', className: 'btn btn-sm btn-success', text: '<i class="bi bi-file-earmark-excel me-1"></i> Excel' },
                { extend: 'pdf', className: 'btn btn-sm btn-danger', text: '<i class="bi bi-file-earmark-pdf me-1"></i> PDF' },
                { extend: 'print', className: 'btn btn-sm btn-dark', text: '<i class="bi bi-printer me-1"></i> Print' }
            ],
            columns: [
                {
                    data: 'user_id',
                    name: 'name_column',
                    render: function(data, type, row) {
                        let avatar = row.profile_picture ? `{{ asset('storage/profiles') }}/${row.profile_picture}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(row.first_name)}&background=random`;
                        return `
                            <div class="d-flex align-items-center ps-2">
                                <img src="${avatar}" class="avatar-sm rounded-circle shadow-sm me-3 border border-2 border-white">
                                <div>
                                    <div class="fw-bold">${row.first_name} ${row.last_name}</div>
                                    <div class="x-small text-muted">${row.employee_id}</div>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'email',
                    render: function(data, type, row) {
                        return `
                            <div class="small">
                                <div><i class="bi bi-envelope-at me-1 text-primary"></i>${data}</div>
                                <div class="text-muted"><i class="bi bi-telephone me-1 text-primary"></i>${row.contact_no || 'N/A'}</div>
                                <span class="badge bg-primary-subtle text-primary border border-primary mt-1" style="font-size: 10px;">${row.role_name || 'Staff'}</span>
                            </div>
                        `;
                    }
                },
                { data: 'organization', name: 'organization' },
                { data: 'manager', name: 'manager' },
                {
                    data: 'date_of_birth',
                    render: function(data, type, row) {
                        let dob = data ? moment(data.replace(/^-+|-+$/g, '')).format('MMM DD, YYYY') : 'N/A';
                        if (dob === 'Invalid date') dob = data; // Fallback to raw string
                        
                        return `
                            <div class="x-small">
                                <div class="text-muted">DOB: ${dob}</div>
                                <div class="text-muted">Blood: <span class="fw-bold text-danger">${row.blood_group || 'O+'}</span></div>
                                <div class="text-primary mt-1 fw-semibold">${row.dates}</div>
                            </div>
                        `;
                    }
                },
                { data: 'status', name: 'is_active' },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-end pe-3',
                    render: function(data, type, row) {
                        let btnHtml = '';
                        @can('manage_employees')
                        btnHtml = `
                            <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                <a href="{{ url('employees') }}/${row.user_id}/edit" class="btn btn-sm btn-white text-primary px-3" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button onclick="deleteEmployee(${row.user_id})" class="btn btn-sm btn-white text-danger px-3" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        `;
                        @else
                        btnHtml = `<span class="badge bg-secondary-subtle text-secondary border border-secondary px-2 py-1"><i class="bi bi-lock me-1"></i>View Only</span>`;
                        @endcan
                        return btnHtml;
                    }
                }
            ],
            language: {
                search: "",
                searchPlaceholder: "Search records...",
                paginate: { next: '›', previous: '‹' }
            }
        });

        // Refresh on filter change
        $('#filter_company, #filter_manager, #filter_status').on('change', function() {
            table.draw();
        });
    });

    function resetFilters() {
        $('#filter_company, #filter_manager').val('');
        $('#filter_status').val('1');
        table.draw();
    }
</script>
@endpush
