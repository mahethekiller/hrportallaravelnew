@extends('layouts.admin')

@section('page_title', 'Resignations')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-door-open me-2"></i>Resignation Management</h4>
            <p class="text-muted mb-0 small">Track and manage employee separations with multi-level approval.</p>
        </div>
        <button class="btn btn-danger shadow-sm rounded-pill px-4" onclick="openSubmitModal()">
            <i class="bi bi-box-arrow-right me-1"></i> Submit Resignation
        </button>
    </div>
</div>

<!-- Filter Bar -->
<div class="glass-card mb-4 p-3">
    <div class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label small fw-bold text-muted">Filter by Employee</label>
            <select class="form-select bg-light border-0 py-2 rounded-3" id="filterEmployee">
                <option value="">All Employees</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->user_id }}">{{ $emp->first_name }} {{ $emp->last_name }} ({{ $emp->employee_id }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-bold text-muted">Status</label>
            <select class="form-select bg-light border-0 py-2 rounded-3" id="filterStatus">
                <option value="all">All Status</option>
                <option value="1">Pending</option>
                <option value="2">Manager Approved</option>
                <option value="3">HR Approved</option>
                <option value="4">Rejected</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100 rounded-pill py-2" onclick="loadResignations()">
                <i class="bi bi-funnel me-1"></i> Filter
            </button>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4" id="statsRow">
    <div class="col-md-3">
        <div class="glass-card text-center p-3">
            <div class="fs-3 fw-bold text-warning" id="statPending">0</div>
            <small class="text-muted">Pending</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card text-center p-3">
            <div class="fs-3 fw-bold text-info" id="statManagerApproved">0</div>
            <small class="text-muted">Manager Approved</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card text-center p-3">
            <div class="fs-3 fw-bold text-success" id="statHRApproved">0</div>
            <small class="text-muted">HR Approved</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card text-center p-3">
            <div class="fs-3 fw-bold text-danger" id="statRejected">0</div>
            <small class="text-muted">Rejected</small>
        </div>
    </div>
</div>

<!-- Resignation Feed -->
<div id="resignationFeed">
    <div class="text-center py-5 text-muted">
        <div class="spinner-border text-primary mb-3" role="status"></div>
        <p>Loading resignations...</p>
    </div>
</div>

<!-- Submit Resignation Modal -->
<div class="modal fade" id="submitModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0" style="border-radius: 24px; box-shadow: 0 15px 50px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold"><i class="bi bi-box-arrow-right me-2 text-danger"></i>Submit Resignation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="resignationForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Employee <span class="text-danger">*</span></label>
                            <select class="form-select bg-light border-0 py-2" id="modal_employee_id" name="employee_id" required>
                                <option value="">-- Select Employee --</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->user_id }}">{{ $emp->first_name }} {{ $emp->last_name }} ({{ $emp->employee_id }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Notice Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control bg-light border-0 py-2" id="modal_notice_date" name="notice_date" required value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted">Notice Period</label>
                            <div class="form-control bg-light border-0 py-2 text-muted" id="modal_notice_period">-- days</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted">Last Working Day</label>
                            <div class="form-control bg-light border-0 py-2 fw-bold text-danger" id="modal_lwd">--</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted">Reporting Manager</label>
                            <div class="form-control bg-light border-0 py-2 text-muted" id="modal_manager">--</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-muted">Reason for Resignation <span class="text-danger">*</span></label>
                            <textarea class="form-control bg-light border-0 py-2" name="reason" rows="3" required placeholder="Please provide a reason..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger rounded-pill px-4" id="submitBtn" onclick="submitResignation()">
                    <i class="bi bi-send me-1"></i> Submit Resignation
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Approval Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 24px; box-shadow: 0 15px 50px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold" id="approvalTitle">Approve Resignation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="approval_id">
                <input type="hidden" id="approval_action">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-muted">Comment (optional)</label>
                    <textarea class="form-control bg-light border-0 py-2" id="approval_comment" rows="3" placeholder="Add a comment..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="approvalBtn" onclick="confirmApproval()">Confirm</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $(document).ready(function() {
        loadResignations();

        // Auto-fetch notice period when employee selected
        $('#modal_employee_id').on('change', function() {
            let empId = $(this).val();
            if (!empId) {
                $('#modal_notice_period').text('-- days');
                $('#modal_lwd').text('--');
                $('#modal_manager').text('--');
                return;
            }
            $.get("{{ url('admin/resignations/notice-period') }}/" + empId, function(data) {
                let np = data.notice_period || 30;
                $('#modal_notice_period').text(np + ' days');
                $('#modal_manager').text(data.manager_name || 'Not Assigned');
                calculateLWD();
            });
        });

        $('#modal_notice_date').on('change', function() {
            calculateLWD();
        });
    });

    function calculateLWD() {
        let noticeText = $('#modal_notice_period').text();
        let np = parseInt(noticeText) || 30;
        let noticeDate = $('#modal_notice_date').val();
        if (noticeDate) {
            let lwd = new Date(noticeDate);
            lwd.setDate(lwd.getDate() + np);
            let options = { day: '2-digit', month: 'short', year: 'numeric' };
            $('#modal_lwd').text(lwd.toLocaleDateString('en-GB', options));
        }
    }

    function loadResignations() {
        let params = {
            employee_id: $('#filterEmployee').val() || '',
            status: $('#filterStatus').val() || 'all'
        };

        $('#resignationFeed').html('<div class="text-center py-5 text-muted"><div class="spinner-border text-primary mb-3"></div><p>Loading...</p></div>');

        $.post("{{ route('resignations.data') }}", params, function(data) {
            // Update stats
            let pending = data.filter(r => r.status == '1').length;
            let mgrApproved = data.filter(r => r.status == '2').length;
            let hrApproved = data.filter(r => r.status == '3').length;
            let rejected = data.filter(r => r.status == '4').length;
            $('#statPending').text(pending);
            $('#statManagerApproved').text(mgrApproved);
            $('#statHRApproved').text(hrApproved);
            $('#statRejected').text(rejected);

            if (data.length === 0) {
                $('#resignationFeed').html('<div class="glass-card text-center py-5"><i class="bi bi-inbox fs-1 text-muted"></i><p class="text-muted mt-2">No resignation requests found.</p></div>');
                return;
            }

            let html = '';
            data.forEach(r => {
                let statusBadge = getStatusBadge(r.status);
                let mgrBadge = getApprovalBadge(r.manager_status, 'Manager');
                let hrBadge = getApprovalBadge(r.hr_status, 'HR');

                let actions = '';
                @if(Auth::user()->can('approve_resignations_hr') || Auth::user()->can('approve_resignations_manager'))
                if (r.status == '1' || r.status == '2') {
                    @can('approve_resignations_hr')
                    actions += `<button class="btn btn-sm btn-success rounded-pill px-3 me-2" onclick="openApproval(${r.id}, 'approve')"><i class="bi bi-check-lg me-1"></i>Approve</button>`;
                    actions += `<button class="btn btn-sm btn-danger rounded-pill px-3" onclick="openApproval(${r.id}, 'reject')"><i class="bi bi-x-lg me-1"></i>Reject</button>`;
                    @endcan
                    @can('approve_resignations_manager')
                    if (r.status == '1') {
                        actions += `<button class="btn btn-sm btn-success rounded-pill px-3 me-2" onclick="openApproval(${r.id}, 'approve')"><i class="bi bi-check-lg me-1"></i>Approve</button>`;
                        actions += `<button class="btn btn-sm btn-danger rounded-pill px-3" onclick="openApproval(${r.id}, 'reject')"><i class="bi bi-x-lg me-1"></i>Reject</button>`;
                    }
                    @endcan
                }
                @endif

                html += `
                <div class="glass-card mb-3 p-4" style="transition: all 0.3s ease;">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width:48px; height:48px;">
                                    <i class="bi bi-person-dash fs-5 text-danger"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">${r.employee_name}</div>
                                    <small class="text-muted">${r.employee_id_str} &bull; ${r.designation}</small><br>
                                    <small class="text-muted"><i class="bi bi-building me-1"></i>${r.department}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small">
                                <div class="mb-1"><i class="bi bi-calendar-event text-primary me-1"></i><strong>Notice:</strong> ${formatDate(r.notice_date)}</div>
                                <div class="mb-1"><i class="bi bi-calendar-x text-danger me-1"></i><strong>LWD:</strong> ${formatDate(r.resignation_date)}</div>
                                <div><i class="bi bi-clock text-muted me-1"></i>${r.notice_period}</div>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            ${statusBadge}
                            <div class="mt-2 d-flex justify-content-center gap-1 flex-wrap">
                                ${mgrBadge}
                                ${hrBadge}
                            </div>
                        </div>
                        <div class="col-md-3 text-end">
                            ${actions}
                            <button class="btn btn-sm btn-light rounded-pill px-3 mt-1" onclick="toggleDetails(${r.id})">
                                <i class="bi bi-chevron-down"></i> Details
                            </button>
                        </div>
                    </div>
                    <div class="row mt-3 d-none" id="details_${r.id}">
                        <div class="col-12">
                            <hr class="my-2">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted">Reason</label>
                                    <p class="small mb-0">${r.reason || 'No reason provided'}</p>
                                </div>
                                <div class="col-md-3">
                                    <label class="small fw-bold text-muted">Manager Comment</label>
                                    <p class="small mb-0">${r.manager_comment || '-'}</p>
                                </div>
                                <div class="col-md-3">
                                    <label class="small fw-bold text-muted">HR Comment</label>
                                    <p class="small mb-0">${r.hr_comment || '-'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            });

            $('#resignationFeed').html(html);
        });
    }

    function getStatusBadge(status) {
        switch(status) {
            case '1': return '<span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">Pending</span>';
            case '2': return '<span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">Manager Approved</span>';
            case '3': return '<span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">HR Approved</span>';
            case '4': return '<span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Rejected</span>';
            default: return '<span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">Unknown</span>';
        }
    }

    function getApprovalBadge(status, label) {
        if (status === 'approved') return `<span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2" style="font-size:0.65rem;">${label} ✓</span>`;
        if (status === 'rejected') return `<span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2" style="font-size:0.65rem;">${label} ✗</span>`;
        return `<span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2" style="font-size:0.65rem;">${label} ○</span>`;
    }

    function formatDate(dateStr) {
        if (!dateStr) return '--';
        let d = new Date(dateStr);
        return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    function toggleDetails(id) {
        $(`#details_${id}`).toggleClass('d-none');
    }

    function openSubmitModal() {
        $('#resignationForm')[0].reset();
        $('#modal_notice_period').text('-- days');
        $('#modal_lwd').text('--');
        $('#modal_manager').text('--');
        $('#modal_notice_date').val('{{ date("Y-m-d") }}');

        // Auto-select current user for self-submission
        $('#modal_employee_id').val('{{ Auth::user()->user_id }}').trigger('change');

        $('#submitModal').modal('show');
    }

    function submitResignation() {
        let originalBtn = $('#submitBtn').html();
        $('#submitBtn').html('<span class="spinner-border spinner-border-sm"></span> Submitting...').prop('disabled', true);

        $.ajax({
            url: "{{ route('resignations.store') }}",
            type: "POST",
            data: $('#resignationForm').serialize(),
            success: function(response) {
                $('#submitModal').modal('hide');
                loadResignations();
                if(typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Resignation Submitted', text: response.success, timer: 3000, showConfirmButton: false });
                }
            },
            error: function(xhr) {
                let msg = 'Error submitting resignation.';
                if(xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                } else if(xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                if(typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'error', title: 'Error', html: msg });
                } else { alert(msg); }
            },
            complete: function() {
                $('#submitBtn').html(originalBtn).prop('disabled', false);
            }
        });
    }

    function openApproval(id, action) {
        $('#approval_id').val(id);
        $('#approval_action').val(action);
        $('#approval_comment').val('');
        if(action === 'approve') {
            $('#approvalTitle').text('Approve Resignation');
            $('#approvalBtn').removeClass('btn-danger').addClass('btn-success').text('Confirm Approval');
        } else {
            $('#approvalTitle').text('Reject Resignation');
            $('#approvalBtn').removeClass('btn-success').addClass('btn-danger').text('Confirm Rejection');
        }
        $('#approvalModal').modal('show');
    }

    function confirmApproval() {
        let id = $('#approval_id').val();
        let action = $('#approval_action').val();
        let comment = $('#approval_comment').val();

        $('#approvalBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.ajax({
            url: "{{ url('admin/resignations') }}/" + id + "/update-status",
            type: "POST",
            data: { action: action, comment: comment },
            success: function(response) {
                $('#approvalModal').modal('hide');
                loadResignations();
                if(typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Success', text: response.success, timer: 2000, showConfirmButton: false });
                }
            },
            error: function(xhr) {
                let msg = xhr.responseJSON?.message || 'Error updating status.';
                if(typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
                } else { alert(msg); }
            },
            complete: function() {
                $('#approvalBtn').prop('disabled', false).text('Confirm');
            }
        });
    }
</script>
@endpush
