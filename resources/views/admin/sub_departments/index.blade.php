@extends('layouts.admin')

@section('page_title', 'Sub Departments')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">Sub Departments Configuration</h4>
            <p class="text-muted mb-0 small">Manage granular organizational units within departments.</p>
        </div>
        <button class="btn btn-primary shadow-sm" onclick="createSubDepartment()">
            <i class="bi bi-plus-lg me-1"></i> Add Sub Department
        </button>
    </div>
</div>

<div class="glass-card">
    <table class="table table-hover w-100" id="subDepartmentsTable">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="45%">Sub Department & Parent</th>
                <th width="20%">Status</th>
                <th width="30%" class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- Sub Department Modal -->
<div class="modal fade" id="subDepartmentModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 24px; box-shadow: 0 15px 50px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold" id="modalTitle">Add Sub Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="subDepartmentForm">
                    <input type="hidden" id="sub_department_id" name="sub_department_id">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Parent Company <span class="text-danger">*</span></label>
                        <select class="form-select bg-light border-0 py-2" id="modal_company_id" name="company_id" required>
                            <option value="">-- Select Company --</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->company_id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Parent Department <span class="text-danger">*</span></label>
                        <select class="form-select bg-light border-0 py-2" id="modal_department_id" name="department_id" required>
                            <option value="">-- Select Department --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Sub Department Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-light border-0 py-2" id="department_name" name="department_name" required placeholder="e.g. Frontend Team">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Status</label>
                        <select class="form-select bg-light border-0 py-2" id="show_status" name="show_status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="saveBtn" onclick="saveSubDepartment()">Save Sub Department</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let table;
    let allDepartments = @json($departments);
    
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $(document).ready(function() {
        table = $('#subDepartmentsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('sub_departments.index') }}",
            language: { search: "_INPUT_", searchPlaceholder: "Search sub departments..." },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'sub_department', name: 'department_name'},
                {data: 'status_badge', name: 'show_status', searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-end'}
            ],
            drawCallback: function() {
                $('.dataTables_filter input').addClass('form-control bg-light border-0 rounded-pill px-3 py-2');
                $('.dataTables_length select').addClass('form-select bg-light border-0 rounded-pill');
            }
        });

        // Cascading: Company -> Department in modal
        $('#modal_company_id').on('change', function() {
            let companyId = $(this).val();
            let filtered = allDepartments.filter(d => d.company_id == companyId);
            let select = $('#modal_department_id');
            select.html('<option value="">-- Select Department --</option>');
            filtered.forEach(d => {
                select.append('<option value="' + d.department_id + '">' + d.department_name + '</option>');
            });
        });
    });

    function createSubDepartment() {
        $('#subDepartmentForm')[0].reset();
        $('#sub_department_id').val('');
        $('#modal_department_id').html('<option value="">-- Select Department --</option>');
        $('#modalTitle').text('Add Sub Department');
        $('#subDepartmentModal').modal('show');
    }

    function editSubDepartment(id) {
        $.get("{{ route('sub_departments.index') }}/" + id + "/edit", function(data) {
            $('#modalTitle').text('Edit Sub Department');
            $('#sub_department_id').val(data.sub_department_id);
            $('#department_name').val(data.department_name);
            $('#modal_company_id').val(data.company_id).trigger('change');
            $('#show_status').val(data.show_status);
            
            // Wait for departments to load, then set department_id
            setTimeout(function() {
                $('#modal_department_id').val(data.department_id);
            }, 200);
            
            $('#subDepartmentModal').modal('show');
        });
    }

    function saveSubDepartment() {
        let id = $('#sub_department_id').val();
        let url = id ? "{{ route('sub_departments.index') }}/" + id : "{{ route('sub_departments.store') }}";
        let type = id ? "PUT" : "POST";
        
        let originalBtn = $('#saveBtn').html();
        $('#saveBtn').html('<span class="spinner-border spinner-border-sm"></span> Saving...').prop('disabled', true);

        $.ajax({
            url: url,
            type: type,
            data: $('#subDepartmentForm').serialize(),
            success: function(response) {
                $('#subDepartmentModal').modal('hide');
                table.ajax.reload();
                if(typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Success', text: response.success, timer: 2000, showConfirmButton: false });
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error saving sub department.';
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

    function deleteSubDepartment(id) {
        if(typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Delete Sub Department?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('sub_departments.index') }}/" + id,
                        type: "DELETE",
                        success: function(response) {
                            table.ajax.reload();
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: response.success, timer: 2000, showConfirmButton: false });
                        }
                    });
                }
            });
        } else {
            if(confirm('Are you sure you want to delete this sub department?')) {
                $.ajax({
                    url: "{{ route('sub_departments.index') }}/" + id,
                    type: "DELETE",
                    success: function(response) { table.ajax.reload(); }
                });
            }
        }
    }
</script>
@endpush
