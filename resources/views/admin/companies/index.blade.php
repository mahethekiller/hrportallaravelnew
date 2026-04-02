@extends('layouts.admin')

@section('page_title', 'Companies Directory')

@push('styles')
<style>
    [data-theme="dark"] #companyModal .modal-content {
        background: var(--bg-sidebar);
        color: var(--text-main);
    }
    [data-theme="dark"] #companyModal .form-label { color: var(--text-muted); }
    [data-theme="dark"] #companyModal .form-control {
        background-color: rgba(255,255,255,0.04) !important;
        border: 1px solid var(--border-muted) !important;
        color: var(--text-main) !important;
    }
    [data-theme="dark"] #companyModal .form-control::placeholder { color: rgba(148,163,184,0.5) !important; }
    [data-theme="dark"] .dataTables_filter input,
    [data-theme="dark"] .dataTables_length select {
        background-color: var(--bg-sidebar) !important;
        color: var(--text-main) !important;
        border-color: var(--border-muted) !important;
    }
</style>
@endpush

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">Companies Management</h4>
            <p class="text-muted mb-0 small">Manage your corporate entities and subsidiaries here.</p>
        </div>
        <button class="btn btn-primary shadow-sm" onclick="createCompany()">
            <i class="bi bi-plus-lg me-1"></i> Add New Company
        </button>
    </div>
</div>

<div class="glass-card">
    <table class="table table-hover w-100" id="companiesTable">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="30%">Company Name</th>
                <th width="20%">Reg. Number</th>
                <th width="30%">Contact Details</th>
                <th width="15%" class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- Company Modal -->
<div class="modal fade" id="companyModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0" style="border-radius: 24px; box-shadow: 0 15px 50px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold" id="modalTitle">Add New Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="companyForm">
                    <input type="hidden" id="company_id" name="company_id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Legal Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control py-2" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Trading Name</label>
                            <input type="text" class="form-control py-2" id="trading_name" name="trading_name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Registration Number</label>
                            <input type="text" class="form-control py-2" id="registration_no" name="registration_no">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control py-2" id="email" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control py-2" id="contact_number" name="contact_number" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Website URL</label>
                            <input type="url" class="form-control py-2" id="website_url" name="website_url">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="saveBtn" onclick="saveCompany()">Save Company</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let table;
    
    // Setup Native Laravel CSRF Token for jQuery AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        table = $('#companiesTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('companies.index') }}",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records..."
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'registration_no', name: 'registration_no'},
                {data: 'contact', name: 'email', searchable: true}, // 'contact' dynamically generates html
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-end'}
            ],
            drawCallback: function() {
                $('.dataTables_filter input').addClass('form-control rounded-pill px-3 py-2');
                $('.dataTables_length select').addClass('form-select rounded-pill');
            }
        });
    });

    function createCompany() {
        $('#companyForm')[0].reset();
        $('#company_id').val('');
        $('#modalTitle').text('Add New Company');
        $('#companyModal').modal('show');
    }

    function editCompany(id) {
        $.get("{{ route('companies.index') }}/" + id + "/edit", function(data) {
            $('#modalTitle').text('Edit Company');
            $('#company_id').val(data.company_id);
            $('#name').val(data.name);
            $('#trading_name').val(data.trading_name);
            $('#registration_no').val(data.registration_no);
            $('#email').val(data.email);
            $('#contact_number').val(data.contact_number);
            $('#website_url').val(data.website_url);
            $('#companyModal').modal('show');
        })
    }

    function saveCompany() {
        let id = $('#company_id').val();
        let url = id ? "{{ route('companies.index') }}/" + id : "{{ route('companies.store') }}";
        let type = id ? "PUT" : "POST";
        
        let originalBtn = $('#saveBtn').html();
        $('#saveBtn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...').prop('disabled', true);

        $.ajax({
            url: url,
            type: type,
            data: $('#companyForm').serialize(),
            success: function(response) {
                $('#companyModal').modal('hide');
                table.ajax.reload();
                if(typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Success', text: response.success, timer: 2000, showConfirmButton: false });
                } else {
                    alert(response.success);
                }
            },
            error: function(xhr) {
                let errorMsg = 'Something went wrong! Please check the form and try again.';
                if(xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                } else if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                
                if(typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'error', title: 'Validation Error', html: errorMsg });
                } else {
                    alert('Error:\n' + errorMsg.replace(/<br>/g, '\n'));
                }
            },
            complete: function() {
                $('#saveBtn').html(originalBtn).prop('disabled', false);
            }
        });
    }

    function deleteCompany(id) {
        if(confirm('Are you absolutely sure you want to permanently delete this company?')) {
            $.ajax({
                url: "{{ route('companies.index') }}/" + id,
                type: "DELETE",
                success: function(response) {
                    table.ajax.reload();
                }
            });
        }
    }
</script>
@endpush
