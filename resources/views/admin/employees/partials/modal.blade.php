<!-- Employee Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0" style="border-radius: 24px; box-shadow: 0 15px 50px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold" id="modalTitle">Add New Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="employeeForm">
                    <input type="hidden" id="user_id" name="user_id">
                    
                    <div class="row g-3 mb-4">
                        <div class="col-12"><small class="text-primary fw-bold text-uppercase small">Personal & Account Information</small></div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted">Employee ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light border-0 py-2 rounded-3" id="employee_id" name="employee_id" required placeholder="EMP-001">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light border-0 py-2 rounded-3" id="first_name" name="first_name" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light border-0 py-2 rounded-3" id="last_name" name="last_name" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-semibold text-muted">Work Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control bg-light border-0 py-2 rounded-3" id="email" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Login Password <span id="pwdReq" class="text-danger">*</span></label>
                            <input type="password" class="form-control bg-light border-0 py-2 rounded-3" id="password" name="password" placeholder="Min. 6 characters">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Account Status <span class="text-danger">*</span></label>
                            <select class="form-select bg-light border-0 py-2 rounded-3" id="is_active" name="is_active" required>
                                <option value="1" selected>Active</option>
                                <option value="2">Terminated</option>
                                <option value="3">Left</option>
                                <option value="4">Abscond</option>
                                <option value="5">Disable</option>
                                <option value="0">Resigned</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Assigned System Role <span class="text-danger">*</span></label>
                            <select class="form-select bg-light border-0 py-2 rounded-3" id="role_name" name="role_name" required>
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12"><small class="text-primary fw-bold text-uppercase small">Organizational Assignment</small></div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted">Company <span class="text-danger">*</span></label>
                            <select class="form-select bg-light border-0 py-2 rounded-3" id="company_id" name="company_id" required>
                                <option value="">-- Select --</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->company_id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted">Department <span class="text-danger">*</span></label>
                            <select class="form-select bg-light border-0 py-2 rounded-3" id="department_id" name="department_id" required>
                                <option value="">-- Select Company First --</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted">Designation <span class="text-danger">*</span></label>
                            <select class="form-select bg-light border-0 py-2 rounded-3" id="designation_id" name="designation_id" required>
                                <option value="">-- Select Department First --</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="saveBtn" onclick="saveEmployee()">Save Employee</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Cascading Dropdowns
    $('#company_id').on('change', function() {
        let company_id = $(this).val();
        $('#department_id').html('<option value="">Loading...</option>');
        $('#designation_id').html('<option value="">-- Select --</option>');
        
        if(company_id) {
            $.get("{{ url('get-departments') }}/" + company_id, function(data) {
                let html = '<option value="">-- Select Department --</option>';
                data.forEach(function(item) {
                    html += `<option value="${item.department_id}">${item.department_name}</option>`;
                });
                $('#department_id').html(html);
            });
        }
    });

    $('#department_id').on('change', function() {
        let department_id = $(this).val();
        $('#designation_id').html('<option value="">Loading...</option>');
        
        if(department_id) {
            $.get("{{ url('get-designations') }}/" + department_id, function(data) {
                let html = '<option value="">-- Select Designation --</option>';
                data.forEach(function(item) {
                    html += `<option value="${item.designation_id}">${item.designation_name}</option>`;
                });
                $('#designation_id').html(html);
            });
        }
    });

    function createEmployee() {
        $('#employeeForm')[0].reset();
        $('#user_id').val('');
        $('#pwdReq').show();
        $('#modalTitle').text('Add New Employee');
        $('#employeeModal').modal('show');
    }

    function saveEmployee() {
        let id = $('#user_id').val();
        let url = id ? "{{ route('employees.index') }}/" + id : "{{ route('employees.store') }}";
        let type = id ? "PUT" : "POST";
        
        let originalBtn = $('#saveBtn').html();
        $('#saveBtn').html('<span class="spinner-border spinner-border-sm"></span> Saving...').prop('disabled', true);

        $.ajax({
            url: url,
            type: type,
            data: $('#employeeForm').serialize(),
            success: function(response) {
                $('#employeeModal').modal('hide');
                table.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.success,
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function(xhr) {
                let errorMsg = 'Something went wrong! Please check the form and try again.';
                if(xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMsg
                });
            },
            complete: function() {
                $('#saveBtn').html(originalBtn).prop('disabled', false);
            }
        });
    }

    function deleteEmployee(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('employees.index') }}/" + id,
                    type: "DELETE",
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire('Deleted!', response.success, 'success');
                    }
                });
            }
        });
    }
</script>
@endpush
