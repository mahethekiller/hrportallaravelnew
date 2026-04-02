@extends('layouts.admin')

@section('page_title', 'Permission Management')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">System Permissions</h4>
            <p class="text-muted mb-0 small">Manage the raw granular permissions available across the HRMS.</p>
        </div>
        <button class="btn btn-primary shadow-sm" onclick="createPermission()">
            <i class="bi bi-key-fill me-1"></i> Add Permission
        </button>
    </div>
</div>

<div class="glass-card">
    <table class="table table-hover w-100" id="permissionsTable">
        <thead>
            <tr>
                <th width="10%">#</th>
                <th width="50%">Permission Name</th>
                <th width="20%">Group</th>
                <th width="20%" class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- Permission Modal -->
<div class="modal fade" id="permissionModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 24px; box-shadow: 0 15px 50px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold">Add New Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="permissionForm">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Permission Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-light border-0 py-2 rounded-3" id="name" name="name" required placeholder="e.g. manage_employees">
                        <small class="text-muted">Use snake_case for consistency (e.g. view_payroll).</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="saveBtn" onclick="savePermission()">Save Permission</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let table;
    
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $(document).ready(function() {
        table = $('#permissionsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('permissions.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name', className: 'fw-bold text-dark'},
                {data: 'group', name: 'group', searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-end'}
            ],
            language: { search: "_INPUT_", searchPlaceholder: "Search permissions..." }
        });
    });

    function createPermission() {
        $('#permissionForm')[0].reset();
        $('#permissionModal').modal('show');
    }

    function savePermission() {
        let url = "{{ route('permissions.store') }}";
        let originalBtn = $('#saveBtn').html();
        $('#saveBtn').html('<span class="spinner-border spinner-border-sm"></span> Saving...').prop('disabled', true);

        $.ajax({
            url: url,
            type: "POST",
            data: $('#permissionForm').serialize(),
            success: function(response) {
                $('#permissionModal').modal('hide');
                table.ajax.reload();
            },
            error: function(xhr) {
                if(xhr.responseJSON && xhr.responseJSON.errors) {
                    alert('Validation error: ' + Object.values(xhr.responseJSON.errors).flat().join('\n'));
                } else {
                    alert('Error saving permission.');
                }
            },
            complete: function() {
                $('#saveBtn').html(originalBtn).prop('disabled', false);
            }
        });
    }

    function deletePermission(id) {
        if(confirm('Are you sure you want to delete this permission?')) {
            $.ajax({
                url: "{{ route('permissions.index') }}/" + id,
                type: "DELETE",
                success: function(response) {
                    table.ajax.reload();
                }
            });
        }
    }
</script>
@endpush
