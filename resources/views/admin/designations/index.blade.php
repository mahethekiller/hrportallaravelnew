@extends('layouts.admin')

@section('page_title', 'Designations')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">Designations Hub</h4>
            <p class="text-muted mb-0 small">Manage organizational job titles and hierarchical mapping.</p>
        </div>
        <button class="btn btn-primary shadow-sm" onclick="createDesignation()">
            <i class="bi bi-award me-1"></i> Add Designation
        </button>
    </div>
</div>

<div class="glass-card">
    <table class="table table-hover w-100" id="designationsTable">
        <thead>
            <tr>
                <th width="10%">#</th>
                <th width="40%">Designation</th>
                <th width="30%">Organization / Dept</th>
                <th width="20%" class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- Designation Modal -->
<div class="modal fade" id="designationModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 24px; box-shadow: 0 15px 50px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold" id="modalTitle">Add New Designation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="designationForm">
                    <input type="hidden" id="designation_id" name="designation_id">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Designation Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-light border-0 py-2 rounded-3" id="designation_name" name="designation_name" required placeholder="e.g. Senior Software Engineer">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Company <span class="text-danger">*</span></label>
                        <select class="form-select bg-light border-0 py-2 rounded-3" id="company_id" name="company_id" required>
                            <option value="">-- Select Company --</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->company_id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Department <span class="text-danger">*</span></label>
                        <select class="form-select bg-light border-0 py-2 rounded-3" id="department_id" name="department_id" required>
                            <option value="">-- Select Department --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->department_id }}">{{ $dept->department_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="saveBtn" onclick="saveDesignation()">Save Designation</button>
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
        table = $('#designationsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('designations.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'designation', name: 'designation_name', className: 'fw-bold text-dark'},
                {data: 'organization', name: 'company.name', orderable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-end'}
            ],
            language: { search: "_INPUT_", searchPlaceholder: "Search designations..." }
        });
    });

    function createDesignation() {
        $('#designationForm')[0].reset();
        $('#designation_id').val('');
        $('#modalTitle').text('Add New Designation');
        $('#designationModal').modal('show');
    }

    function editDesignation(id) {
        $.get("{{ route('designations.index') }}/" + id + "/edit", function(data) {
            $('#modalTitle').text('Edit Designation');
            $('#designation_id').val(data.designation_id);
            $('#designation_name').val(data.designation_name);
            $('#company_id').val(data.company_id);
            $('#department_id').val(data.department_id);
            $('#designationModal').modal('show');
        });
    }

    function saveDesignation() {
        let id = $('#designation_id').val();
        let url = id ? "{{ route('designations.index') }}/" + id : "{{ route('designations.store') }}";
        let type = id ? "PUT" : "POST";
        
        let originalBtn = $('#saveBtn').html();
        $('#saveBtn').html('<span class="spinner-border spinner-border-sm"></span> Saving...').prop('disabled', true);

        $.ajax({
            url: url,
            type: type,
            data: $('#designationForm').serialize(),
            success: function(response) {
                $('#designationModal').modal('hide');
                table.ajax.reload();
                if(typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Success', text: response.success, timer: 2000, showConfirmButton: false });
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error saving designation. Please check your data and try again.';
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

    function deleteDesignation(id) {
        if(confirm('Are you sure you want to delete this designation?')) {
            $.ajax({
                url: "{{ route('designations.index') }}/" + id,
                type: "DELETE",
                success: function(response) {
                    table.ajax.reload();
                }
            });
        }
    }
</script>
@endpush
