@extends('layouts.admin')

@section('page_title', 'Role Management')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">Roles & Access Control</h4>
            <p class="text-muted mb-0 small">Define system roles and their respective permissions.</p>
        </div>
        <button class="btn btn-primary shadow-sm" onclick="createRole()">
            <i class="bi bi-shield-plus me-1"></i> Add New Role
        </button>
    </div>
</div>

<div class="glass-card">
    <table class="table table-hover w-100" id="rolesTable">
        <thead>
            <tr>
                <th width="10%">#</th>
                <th width="50%">Role Name</th>
                <th width="20%">Permissions</th>
                <th width="20%" class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- Role Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0" style="border-radius: 24px; box-shadow: 0 15px 50px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold" id="modalTitle">Add New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="roleForm">
                    <input type="hidden" id="role_id" name="role_id">
                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-muted">Role Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-light border-0 py-2 rounded-3" id="name" name="name" required placeholder="e.g. Sales Manager">
                    </div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" id="roleTabs" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold text-primary" data-bs-toggle="tab" data-bs-target="#modules-tab" type="button" role="tab"><i class="bi bi-layout-sidebar"></i> Sidebar Modules</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-primary" data-bs-toggle="tab" data-bs-target="#permissions-tab" type="button" role="tab"><i class="bi bi-shield-check"></i> Permissions</button>
                      </li>
                    </ul>
                    
                    <div class="tab-content border-0 p-0">
                        <div class="tab-pane fade show active" id="modules-tab" role="tabpanel">
                            <div class="row overflow-auto" style="max-height: 400px; padding: 10px;">
                                @foreach($allModules as $section => $modules)
                                    <div class="col-md-6 mb-4">
                                        <div class="p-3 bg-light rounded-4 border h-100">
                                            <h6 class="fw-bold text-uppercase small text-primary mb-3">{{ str_replace('_', ' ', $section == 'general' ? 'general' : $section) }} Modules</h6>
                                            @foreach($modules as $module)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input module-checkbox" type="checkbox" name="modules[]" value="{{ $module->id }}" id="mod_{{ $module->id }}">
                                                    <label class="form-check-label small" for="mod_{{ $module->id }}">
                                                        <i class="bi {{ $module->icon }} me-1"></i> {{ $module->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="tab-pane fade" id="permissions-tab" role="tabpanel">
                            <div class="row overflow-auto" style="max-height: 400px; padding: 10px;">
                                @foreach($allPermissions as $group => $permissions)
                                    <div class="col-md-6 mb-4">
                                        <div class="p-3 bg-light rounded-4 border h-100">
                                            <h6 class="fw-bold text-uppercase small text-primary mb-3">{{ $group }} Management</h6>
                                            @foreach($permissions as $permission)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                                    <label class="form-check-label small" for="perm_{{ $permission->id }}">
                                                        {{ str_replace('_', ' ', str_replace($group.'_', '', $permission->name)) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="saveBtn" onclick="saveRole()">Save Role</button>
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
        table = $('#rolesTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('roles.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name', className: 'fw-bold text-dark'},
                {data: 'permissions_count', name: 'permissions_count', searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-end'}
            ],
            language: { search: "_INPUT_", searchPlaceholder: "Search roles..." }
        });
    });

    function createRole() {
        $('#roleForm')[0].reset();
        $('#role_id').val('');
        $('.permission-checkbox').prop('checked', false);
        $('.module-checkbox').prop('checked', false);
        $('#modalTitle').text('Add New Role');
        $('#roleModal').modal('show');
    }

    function editRole(id) {
        $.get("{{ route('roles.index') }}/" + id + "/edit", function(data) {
            $('#modalTitle').text('Edit Role');
            $('#role_id').val(data.role.id);
            $('#name').val(data.role.name);
            
            $('.permission-checkbox').prop('checked', false);
            data.permissions.forEach(perm => {
                $(`.permission-checkbox[value="${perm}"]`).prop('checked', true);
            });

            $('.module-checkbox').prop('checked', false);
            if (data.modules && data.modules.length) {
                data.modules.forEach(modId => {
                    $(`.module-checkbox[value="${modId}"]`).prop('checked', true);
                });
            }
            
            $('#roleModal').modal('show');
        });
    }

    function saveRole() {
        let id = $('#role_id').val();
        let url = id ? "{{ route('roles.index') }}/" + id : "{{ route('roles.store') }}";
        let type = id ? "PUT" : "POST";
        
        let originalBtn = $('#saveBtn').html();
        $('#saveBtn').html('<span class="spinner-border spinner-border-sm"></span> Saving...').prop('disabled', true);

        $.ajax({
            url: url,
            type: type,
            data: $('#roleForm').serialize(),
            success: function(response) {
                $('#roleModal').modal('hide');
                table.ajax.reload();
            },
            error: function(xhr) {
                if(xhr.responseJSON && xhr.responseJSON.errors) {
                    alert('Validation error: ' + Object.values(xhr.responseJSON.errors).flat().join('\n'));
                } else {
                    alert('Error saving role.');
                }
            },
            complete: function() {
                $('#saveBtn').html(originalBtn).prop('disabled', false);
            }
        });
    }

    function deleteRole(id) {
        if(confirm('Are you sure you want to delete this role?')) {
            $.ajax({
                url: "{{ route('roles.index') }}/" + id,
                type: "DELETE",
                success: function(response) {
                    table.ajax.reload();
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.error || 'Error deleting role.');
                }
            });
        }
    }
</script>
@endpush
