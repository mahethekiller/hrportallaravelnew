@extends('layouts.admin')

@section('page_title', 'Leave Management')

@section('content')
<style>
    .leave-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: var(--glass-shadow);
    }

    .leave-card:hover {
        transform: translateY(-5px);
        background: var(--sidebar-active-bg);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .leave-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--accent);
        opacity: 0.8;
    }

    .leave-card.status-approved::before { background: #10b981; }
    .leave-card.status-rejected::before { background: #ef4444; }
    .leave-card.status-pending::before { background: #f59e0b; }

    .avatar-initial {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .date-box {
        background: var(--bg-primary);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 8px 12px;
        text-align: center;
        min-width: 80px;
    }

    .date-box .day { font-size: 1.2rem; font-weight: 800; display: block; line-height: 1; color: var(--text-main); }
    .date-box .month { font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
        opacity: 0.6;
        color: var(--text-main);
    }

    /* Glass Modals */
    .glass-modal .modal-content {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        color: var(--text-main);
        box-shadow: var(--glass-shadow);
    }
    
    [data-theme="dark"] .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }

    .form-control, .form-select {
        background: var(--bg-primary) !important;
        border: 1px solid var(--glass-border) !important;
        color: var(--text-main) !important;
        border-radius: 10px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--accent) !important;
        box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.1) !important;
    }

    .text-muted { color: var(--text-muted) !important; }
    .line-clamp-2 { color: var(--text-main); }
</style>

<div class="container-fluid p-0">
    <!-- Header Actions -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Leave Requests</h4>
            <p class="text-muted small mb-0">Track and manage employee time-off applications</p>
        </div>
        <div class="d-flex gap-2">
            @can('manage_leave_types')
            <button class="btn btn-light px-4 rounded-pill border" data-bs-toggle="modal" data-bs-target="#manageTypesModal">
                <i class="bi bi-gear me-2"></i> Manage Types
            </button>
            @endcan
            <button class="btn btn-primary px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#applyLeaveModal">
                <i class="bi bi-plus-lg me-2"></i> Apply Leave
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="leave-card p-3 mb-4">
        <form id="leaveFilterForm" class="row g-3 align-items-end">
            @if(count($employees) > 0)
            <div class="col-md-4">
                <label class="form-label small text-muted">Filter by Employee</label>
                <select name="employee_id" class="form-select select2-glass">
                    <option value="">All Team Members</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->user_id }}">{{ $emp->first_name }} {{ $emp->last_name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-md-3">
                <label class="form-label small text-muted">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="1">Pending</option>
                    <option value="2">Approved</option>
                    <option value="3">Rejected</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-light w-100 rounded-pill" onclick="refreshLeaves()">
                    <i class="bi bi-filter me-1"></i> Apply Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Timeline Grid -->
    <div id="leavesContainer" class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
        <!-- JS Populated -->
        <div class="col-12 empty-state">
            <div class="spinner-border text-primary mb-3"></div>
            <p>Gathering leave requests...</p>
        </div>
    </div>
</div>

<!-- Modal: Apply Leave -->
<div class="modal fade glass-modal" id="applyLeaveModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">New Leave Application</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="applyLeaveForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small">Leave Type</label>
                        <select name="leave_type_id" class="form-select" required>
                            @foreach($leaveTypes as $type)
                                <option value="{{ $type->leave_type_id }}">{{ $type->type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small">From Date</label>
                            <input type="date" name="from_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small">To Date</label>
                            <input type="date" name="to_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Reason</label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Explain the purpose of your leave..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-link text-white text-decoration-none" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill">Submit Application</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Leave Details & Approval -->
<div class="modal fade glass-modal" id="leaveDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="leaveDetailContent">
            <!-- Populated by JS -->
        </div>
    </div>
</div>

<!-- Modal: Manage Leave Types -->
@can('manage_leave_types')
<div class="modal fade glass-modal" id="manageTypesModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Leave Type Management</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Add New Type Form -->
                <form id="addTypeForm" class="row g-3 mb-4 p-3 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10 align-items-end">
                    @csrf
                    <div class="col-md-5">
                        <label class="form-label small">Type Name</label>
                        <input type="text" name="type_name" class="form-control" placeholder="e.g. Sick Leave" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Days Per Year</label>
                        <input type="number" name="days_per_year" class="form-control" placeholder="12" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill">Add Type</button>
                    </div>
                </form>

                <!-- Types List -->
                <div class="table-responsive">
                    <table class="table table-borderless align-middle text-white mb-0">
                        <thead>
                            <tr class="text-muted small text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">
                                <th>Type Name</th>
                                <th>Days / Year</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody id="typesTableBody">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Leave Dashboard: DOMContentLoaded');
        refreshLeaves();
    });

    $(document).ready(function() {
        console.log('Leave Dashboard: $(document).ready');
        // Initializing Select2 if needed
        $('.select2-glass').select2({
            placeholder: "Filter by employee",
            allowClear: true
        });

        // Apply Leave Form
        $('#applyLeaveForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Submitting...');

            $.post("{{ route('leaves.store') }}", $(this).serialize())
                .done(function(res) {
                    Swal.fire('Success!', res.message, 'success');
                    $('#applyLeaveModal').modal('hide');
                    $('#applyLeaveForm')[0].reset();
                    refreshLeaves();
                })
                .fail(function(xhr) {
                    Swal.fire('Error', xhr.responseJSON.message || 'Something went wrong', 'error');
                })
                .always(() => btn.prop('disabled', false).html('Submit Application'));
        });
    });

    function refreshLeaves() {
        console.log('refreshLeaves: Fetching data...');
        const container = $('#leavesContainer');
        container.html(`
            <div class="col-12 empty-state">
                <div class="spinner-border text-primary mb-3"></div>
                <p>Refreshing requests...</p>
            </div>
        `);

        $.post("{{ route('leaves.data') }}", $('#leaveFilterForm').serialize() + '&_token={{ csrf_token() }}')
            .done(function(res) {
                console.log('refreshLeaves: Data received', res);
                renderLeaves(res.data);
            })
            .fail(function(xhr) {
                console.error('refreshLeaves: Error fetching data', xhr);
                container.html('<div class="col-12 empty-state text-danger"><i class="bi bi-exclamation-triangle h1 d-block mb-3"></i><p>Failed to load leave requests. Please try again.</p></div>');
            });
    }

    // Leave Types Management Logic
    @can('manage_leave_types')
    $('#manageTypesModal').on('show.bs.modal', function() {
        refreshLeaveTypes();
    });

    function refreshLeaveTypes() {
        $.get("{{ route('leave_types.index') }}")
            .done(function(res) {
                const body = $('#typesTableBody');
                body.empty();
                res.data.forEach(type => {
                    body.append(`
                        <tr class="border-bottom border-white border-opacity-5">
                            <td class="fw-bold">${type.type_name}</td>
                            <td>${type.days_per_year} Days</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" ${type.status ? 'checked' : ''} onchange="toggleTypeStatus(${type.leave_type_id}, this.checked)">
                                </div>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-link text-danger p-0" onclick="deleteLeaveType(${type.leave_type_id})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                });
            });
    }

    $('#addTypeForm').on('submit', function(e) {
        e.preventDefault();
        const btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.post("{{ route('leave_types.store') }}", $(this).serialize())
            .done(function(res) {
                Swal.fire('Success', res.message, 'success');
                $('#addTypeForm')[0].reset();
                refreshLeaveTypes();
                // Optionally refresh the main leave application form dropdown
                location.reload(); // Quickest way to update all dropdowns
            })
            .fail(function(xhr) {
                Swal.fire('Error', xhr.responseJSON.message || 'Failed to add type', 'error');
            })
            .always(() => btn.prop('disabled', false).text('Add Type'));
    });

    function toggleTypeStatus(id, status) {
        $.post("{{ url('admin/leave-types') }}/" + id + "/update", {
            _token: '{{ csrf_token() }}',
            status: status ? 1 : 0
        }).done(function() {
            toast('Status updated');
        });
    }

    function deleteLeaveType(id) {
        if (!confirm('Are you sure you want to delete this leave type?')) return;
        
        $.ajax({
            url: "{{ url('admin/leave-types') }}/" + id,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(res) {
                Swal.fire('Deleted!', res.message, 'success');
                refreshLeaveTypes();
            }
        });
    }

    function toast(msg) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            icon: 'success',
            title: msg,
            background: 'var(--glass-bg)',
            color: 'var(--text-main)'
        });
    }
    @endcan

    function renderLeaves(data) {
        const container = $('#leavesContainer');
        container.empty();

        if (data.length === 0) {
            container.html('<div class="col-12 empty-state"><i class="bi bi-emoji-neutral h1 d-block mb-3"></i><p>No leave records found</p></div>');
            return;
        }

        data.forEach(item => {
            const card = `
                <div class="col">
                    <div class="leave-card status-${item.status.toLowerCase()} p-3 h-100" onclick="showLeaveDetails(${JSON.stringify(item).replace(/"/g, '&quot;')})">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="avatar-initial">${item.initials}</div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-0 fw-bold text-truncate">${item.employee_name}</h6>
                                <small class="text-muted">${item.leave_type}</small>
                            </div>
                            <span class="status-badge bg-${item.status_class}-subtle text-${item.status_class}">
                                ${item.status}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="date-box">
                                <span class="month">${item.from_date.split(' ')[1]}</span>
                                <span class="day">${item.from_date.split(' ')[0]}</span>
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-arrow-right"></i>
                                <span class="d-block">${item.duration}</span>
                            </div>
                            <div class="date-box">
                                <span class="month">${item.to_date.split(' ')[1]}</span>
                                <span class="day">${item.to_date.split(' ')[0]}</span>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <p class="small text-muted mb-0 line-clamp-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                ${item.reason}
                            </p>
                            <hr class="my-2 opacity-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted" style="font-size: 0.65rem;">Applied: ${item.applied_on}</small>
                                <button class="btn btn-sm btn-link text-primary p-0 text-decoration-none small">View Details</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.append(card);
        });
    }

    function showLeaveDetails(item) {
        let actionButtons = '';

        // Show approval buttons if user has permissions and leave is pending
        @if(Auth::user()->can('manage_leaves'))
            if (item.status === 'Pending') {
                actionButtons = `
                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-success flex-grow-1 rounded-pill" onclick="updateStatus(${item.leave_id}, 2)">
                            <i class="bi bi-check-lg"></i> Approve
                        </button>
                        <button class="btn btn-danger flex-grow-1 rounded-pill" onclick="updateStatus(${item.leave_id}, 3)">
                            <i class="bi bi-x-lg"></i> Reject
                        </button>
                    </div>
                    <div class="mt-3">
                        <label class="form-label small text-muted">Admin Remarks</label>
                        <textarea id="remarks_${item.leave_id}" class="form-control" rows="2" placeholder="Reason for approval/rejection...">${item.remarks || ''}</textarea>
                    </div>
                `;
            }
        @endif

        const content = `
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Leave Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="avatar-initial">${item.initials}</div>
                    <div>
                        <h5 class="mb-0 fw-bold">${item.employee_name}</h5>
                        <p class="text-muted mb-0">${item.leave_type}</p>
                    </div>
                </div>

                <div class="row g-3 mb-4 text-center">
                    <div class="col-6">
                        <div class="p-3 rounded-4 bg-white bg-opacity-5">
                            <small class="text-muted d-block text-uppercase mb-1" style="font-size: 0.6rem;">From</small>
                            <h6 class="mb-0">${item.from_date}</h6>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-4 bg-white bg-opacity-5">
                            <small class="text-muted d-block text-uppercase mb-1" style="font-size: 0.6rem;">To</small>
                            <h6 class="mb-0">${item.to_date}</h6>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="small text-muted text-uppercase mb-1 d-block">Reason for Leave</label>
                    <div class="p-3 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                        ${item.reason}
                    </div>
                </div>

                ${item.status !== 'Pending' ? `
                    <div class="mb-3">
                        <label class="small text-muted text-uppercase mb-1 d-block">Admin Remarks</label>
                        <div class="p-3 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                            ${item.remarks || 'No remarks provided.'}
                        </div>
                    </div>
                ` : ''}

                ${actionButtons}
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-link text-white text-decoration-none" data-bs-dismiss="modal">Close</button>
            </div>
        `;

        $('#leaveDetailContent').html(content);
        $('#leaveDetailModal').modal('show');
    }

    function updateStatus(id, status) {
        const remarks = $(`#remarks_${id}`).val();
        const url = "{{ url('leaves') }}/" + id + "/update-status";

        $.post(url, {
            _token: '{{ csrf_token() }}',
            status: status,
            remarks: remarks
        }).done(function(res) {
            Swal.fire('Updated!', res.message, 'success');
            $('#leaveDetailModal').modal('hide');
            refreshLeaves();
        }).fail(function() {
            Swal.fire('Error', 'Failed to update status', 'error');
        });
    }
</script>
@endpush
