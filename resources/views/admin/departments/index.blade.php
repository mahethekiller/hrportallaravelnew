@extends('layouts.admin')

@section('page_title', 'Departments')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">Departments Configuration</h4>
            <p class="text-muted mb-0 small">Map out your organizational structure securely.</p>
        </div>
        <button class="btn btn-primary shadow-sm" onclick="createDepartment()">
            <i class="bi bi-plus-lg me-1"></i> Add New Department
        </button>
    </div>
</div>

<div class="glass-card">
    <table class="table table-hover w-100" id="departmentsTable">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="45%">Department & Company</th>
                <th width="20%">Status</th>
                <th width="30%" class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- Department Modal -->
<div class="modal fade" id="departmentModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 24px; box-shadow: 0 15px 50px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold" id="modalTitle">Add New Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="departmentForm">
                    <input type="hidden" id="department_id" name="department_id">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Department Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-light border-0 py-2" id="department_name" name="department_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Parent Company <span class="text-danger">*</span></label>
                        <select class="form-select bg-light border-0 py-2" id="company_id" name="company_id" required>
                            <option value="">-- Select Company --</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->company_id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Status</label>
                        <select class="form-select bg-light border-0 py-2" id="status" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="saveBtn" onclick="saveDepartment()">Save Department</button>
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
        table = $('#departmentsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('departments.index') }}",
            language: { search: "_INPUT_", searchPlaceholder: "Search departments..." },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'department', name: 'department_name'},
                {data: 'status_badge', name: 'status', searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-end'}
            ],
            drawCallback: function() {
                $('.dataTables_filter input').addClass('form-control bg-light border-0 rounded-pill px-3 py-2');
                $('.dataTables_length select').addClass('form-select bg-light border-0 rounded-pill');
            }
        });
    });

    function createDepartment() {
        $('#departmentForm')[0].reset();
        $('#department_id').val('');
        $('#modalTitle').text('Add New Department');
        $('#departmentModal').modal('show');
    }

    function editDepartment(id) {
        $.get("{{ route('departments.index') }}/" + id + "/edit", function(data) {
            $('#modalTitle').text('Edit Department');
            $('#department_id').val(data.department_id);
            $('#department_name').val(data.department_name);
            $('#company_id').val(data.company_id);
            $('#status').val(data.status);
            $('#departmentModal').modal('show');
        })
    }

    function saveDepartment() {
        let id = $('#department_id').val();
        let url = id ? "{{ route('departments.index') }}/" + id : "{{ route('departments.store') }}";
        let type = id ? "PUT" : "POST";
        
        let originalBtn = $('#saveBtn').html();
        $('#saveBtn').html('<span class="spinner-border spinner-border-sm"></span> Saving...').prop('disabled', true);

        $.ajax({
            url: url,
            type: type,
            data: $('#departmentForm').serialize(),
            success: function(response) {
                $('#departmentModal').modal('hide');
                table.ajax.reload();
                if(typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Success', text: response.success, timer: 2000, showConfirmButton: false });
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error saving department. Please check your data and try again.';
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

    function deleteDepartment(id) {
        if(confirm('Are you sure you want to delete this department?')) {
            $.ajax({
                url: "{{ route('departments.index') }}/" + id,
                type: "DELETE",
                success: function(response) {
                    table.ajax.reload();
                }
            });
        }
    }
</script>
@endpush
