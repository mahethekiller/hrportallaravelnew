@extends('layouts.admin')

@section('page_title', 'Edit Employee - ' . $employee->first_name . ' ' . $employee->last_name)

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-person-gear me-2"></i>Employee Profile Editor</h4>
            <p class="text-muted mb-0 small">Comprehensive management for <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong> ({{ $employee->employee_id }})</p>
        </div>
        <a href="{{ route('employees.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Directory
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Quick Nav & Profile Summary -->
    <div class="col-lg-3">
        <div class="glass-card text-center p-4 sticky-top" style="top: 100px; z-index: 10;">
            <div class="position-relative d-inline-block mb-3">
                <img id="avatarPreview" src="{{ $employee->profile_picture ? asset('storage/profiles/' . $employee->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($employee->first_name) . '&background=random&size=256' }}" class="rounded-circle shadow-sm" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;">
                <label for="profile_picture" class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0 p-2 border-white border-2" style="cursor: pointer;">
                    <i class="bi bi-camera"></i>
                </label>
            </div>
            <h5 class="fw-bold mb-1">{{ $employee->first_name }} {{ $employee->last_name }}</h5>
            <p class="text-muted small mb-3">{{ $employee->designation->designation_name ?? 'No Designation' }}</p>

            <hr class="my-4 opacity-50">

            <!-- Profile Navigation -->
            <div class="list-group list-group-flush gap-2 border-0" id="profileTabs" role="tablist">
                <a class="list-group-item list-group-item-action active border-0 rounded-3 py-3 d-flex align-items-center" id="basic-tab" data-bs-toggle="list" data-bs-target="#basic" role="tab" aria-controls="basic" aria-selected="true">
                    <i class="bi bi-person me-3 fs-5 text-center" style="width: 25px;"></i> Basic Information
                </a>
                <a class="list-group-item list-group-item-action border-0 rounded-3 py-3 d-flex align-items-center" id="academic-tab" data-bs-toggle="list" data-bs-target="#academic" role="tab" aria-controls="academic" aria-selected="false">
                    <i class="bi bi-mortarboard me-3 fs-5 text-center" style="width: 25px;"></i> Academic & Career
                </a>
                <a class="list-group-item list-group-item-action border-0 rounded-3 py-3 d-flex align-items-center" id="performance-tab" data-bs-toggle="list" data-bs-target="#performance" role="tab" aria-controls="performance" aria-selected="false">
                    <i class="bi bi-graph-up-arrow me-3 fs-5 text-center" style="width: 25px;"></i> Performance Hub
                </a>
                <a class="list-group-item list-group-item-action border-0 rounded-3 py-3 d-flex align-items-center" id="compliance-tab" data-bs-toggle="list" data-bs-target="#compliance" role="tab" aria-controls="compliance" aria-selected="false">
                    <i class="bi bi-shield-check me-3 fs-5 text-center" style="width: 25px;"></i> Compliance & Finance
                </a>
                <a class="list-group-item list-group-item-action border-0 rounded-3 py-3 d-flex align-items-center" id="security-tab" data-bs-toggle="list" data-bs-target="#security" role="tab" aria-controls="security" aria-selected="false">
                    <i class="bi bi-lock me-3 fs-5 text-center" style="width: 25px;"></i> Security & Verification
                </a>
                <a class="list-group-item list-group-item-action border-0 rounded-3 py-3 d-flex align-items-center" id="social-tab" data-bs-toggle="list" data-bs-target="#social" role="tab" aria-controls="social" aria-selected="false">
                    <i class="bi bi-share me-3 fs-5 text-center" style="width: 25px;"></i> Social Links
                </a>
            </div>
        </div>
    </div>

    <!-- Main Form Area -->
    <div class="col-lg-9">
        <form id="editEmployeeForm" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')
            <input type="file" id="profile_picture" name="profile_picture" class="d-none" accept="image/*">
            <div class="tab-content" id="profileTabsContent">
                <!-- Zone 1: Basic Information -->
                <div class="tab-pane show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                    <div class="glass-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Official & Personal Basics</h5>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $employee->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold small text-primary ms-2">Account Active</label>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Employee ID</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="employee_id" value="{{ $employee->employee_id }}" readonly title="System generated ID">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Account Role</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3" name="role_name" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $employee->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">First Name</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="first_name" value="{{ $employee->first_name }}" required>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Last Name</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="last_name" value="{{ $employee->last_name }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Work Email</label>
                                <input type="email" class="form-control bg-light border-0 py-2 rounded-3" name="email" value="{{ $employee->email }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Personal Email</label>
                                <input type="email" class="form-control bg-light border-0 py-2 rounded-3" name="email_personal" value="{{ $employee->email_personal }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Assigned Manager</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3" name="manager_id">
                                    <option value="">-- No Manager --</option>
                                    @foreach($managers as $mgr)
                                        <option value="{{ $mgr->user_id }}" {{ $employee->manager_id == $mgr->user_id ? 'selected' : '' }}>{{ $mgr->first_name }} {{ $mgr->last_name }} ({{ $mgr->employee_id }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Company</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3 cascading-comp" name="company_id" required>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->company_id }}" {{ $employee->company_id == $company->company_id ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Department</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3 cascading-dept" name="department_id" id="edit_department_id" required>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->department_id }}" {{ $employee->department_id == $dept->department_id ? 'selected' : '' }}>{{ $dept->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Sub Department</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3 cascading-sub-dept" name="sub_department_id" id="edit_sub_department_id">
                                    <option value="">-- Select Sub Department --</option>
                                    @isset($sub_departments)
                                    @foreach($sub_departments as $subDept)
                                        <option value="{{ $subDept->sub_department_id }}" {{ ($employee->sub_department_id ?? '') == $subDept->sub_department_id ? 'selected' : '' }}>{{ $subDept->department_name }}</option>
                                    @endforeach
                                    @endisset
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Designation</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3 cascading-desig" name="designation_id" id="edit_designation_id" required>
                                    @foreach($designations as $desig)
                                        <option value="{{ $desig->designation_id }}" {{ $employee->designation_id == $desig->designation_id ? 'selected' : '' }}>{{ $desig->designation_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Joining Date</label>
                                <input type="date" class="form-control bg-light border-0 py-2 rounded-3" name="date_of_joining" value="{{ $employee->date_of_joining }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Date of Birth</label>
                                <input type="date" class="form-control bg-light border-0 py-2 rounded-3" name="date_of_birth" value="{{ $employee->date_of_birth }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Gender</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3" name="gender">
                                    <option value="Male" {{ $employee->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $employee->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Blood Group</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="blood_group" value="{{ $employee->blood_group }}" placeholder="e.g. O+">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Marital Status</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3" name="marital_status">
                                    <option value="Single" {{ $employee->marital_status == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ $employee->marital_status == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Widowed" {{ $employee->marital_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                    <option value="Divorced" {{ $employee->marital_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Office Shift</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3" name="office_shift_id">
                                    <option value="">-- Select Shift --</option>
                                    @isset($office_shifts)
                                    @foreach($office_shifts as $shift)
                                        <option value="{{ $shift->office_shift_id }}" {{ $employee->office_shift_id == $shift->office_shift_id ? 'selected' : '' }}>{{ $shift->shift_name }}</option>
                                    @endforeach
                                    @endisset
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Personal Phone</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="contact_no" value="{{ $employee->contact_no }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Official Phone</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="official_contact_no" value="{{ $employee->official_contact_no }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Current Address</label>
                                <textarea class="form-control bg-light border-0 py-2 rounded-3" name="address" rows="3" placeholder="Full residential address">{{ $employee->address }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Permanent Address</label>
                                <textarea class="form-control bg-light border-0 py-2 rounded-3" name="address_com" rows="3" placeholder="Full legal address">{{ $employee->address_com }}</textarea>
                            </div>

                        </div>

                        <hr class="my-4 opacity-50">
                        <h5 class="fw-bold mb-4">Advanced HR Details</h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Age</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="age" value="{{ $employee->age }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Mother Tongue</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="mother_tongue" value="{{ $employee->mother_tongue }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Card Number</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="card_no" value="{{ $employee->card_no }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Employment Type</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3" name="employment_type">
                                    <option value="Full Time" {{ $employee->employment_type == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                    <option value="Part Time" {{ $employee->employment_type == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                                    <option value="Contract" {{ $employee->employment_type == 'Contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="Intern" {{ $employee->employment_type == 'Intern' ? 'selected' : '' }}>Intern</option>
                                </select>
                            </div>

                            <!-- Vehicle Details -->
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Vehicle Type</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="vehicle_type" value="{{ $employee->vehicle_type }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Vehicle Number</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="vehicle_no" value="{{ $employee->vehicle_no }}">
                            </div>
                            
                            <!-- Financial & Compensation Details -->
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Current Salary P.A (INR)</label>
                                <input type="number" step="0.01" class="form-control bg-light border-0 py-2 rounded-3" name="salary" value="{{ $employee->salary }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Corporate Bank Account</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="corporate_bank_account" value="{{ $employee->corporate_bank_account }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Opted for PF</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3" name="pf_opted">
                                    <option value="No" {{ $employee->pf_opted == 'No' ? 'selected' : '' }}>No</option>
                                    <option value="Yes" {{ $employee->pf_opted == 'Yes' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                            
                            <!-- Notice & Probation -->
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Notice Period (Months)</label>
                                <input type="number" class="form-control bg-light border-0 py-2 rounded-3" name="notice_period" value="{{ $employee->notice_period }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Probation Status</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3" name="probation_status">
                                    <option value="In Probation" {{ $employee->probation_status == 'In Probation' ? 'selected' : '' }}>In Probation</option>
                                    <option value="Completed" {{ $employee->probation_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Probation End Date</label>
                                <input type="date" class="form-control bg-light border-0 py-2 rounded-3" name="probation_end_date" value="{{ $employee->probation_end_date }}">
                            </div>

                            <!-- Lifecycle Dates -->
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Confirmation Date</label>
                                <input type="date" class="form-control bg-light border-0 py-2 rounded-3" name="confirmation_date" value="{{ $employee->confirmation_date }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Resignation Date</label>
                                <input type="date" class="form-control bg-light border-0 py-2 rounded-3" name="resign_date" value="{{ $employee->resign_date }}">
                            </div>

                            <!-- Source & Rejoin -->
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Employee Source</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3" name="employee_source" id="employeeSourceSelect">
                                    @php $sources = ['Direct', 'Job Board', 'Social Media', 'Reference', 'Referral', 'Recruiter', 'Vendor']; @endphp
                                    <option value="">-- Select Source --</option>
                                    @foreach($sources as $src)
                                        <option value="{{ $src }}" {{ $employee->employee_source == $src ? 'selected' : '' }}>{{ $src }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3 source-field" id="field_referral" style="{{ in_array($employee->employee_source, ['Reference', 'Referral']) ? '' : 'display: none;' }}">
                                <label class="form-label small fw-bold text-muted">Select Referral</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3" name="ref_emp_id_emp">
                                    <option value="">-- Select Employee --</option>
                                    @foreach($managers as $mgr)
                                        <option value="{{ $mgr->user_id }}" {{ $employee->ref_emp_id == $mgr->user_id ? 'selected' : '' }}>{{ $mgr->first_name }} {{ $mgr->last_name }} ({{ $mgr->employee_id }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 source-field" id="field_recruiter" style="{{ in_array($employee->employee_source, ['Recruiter', 'Job Board']) ? '' : 'display: none;' }}">
                                <label class="form-label small fw-bold text-muted">Select Recruiter</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3" name="ref_emp_id_rec">
                                    <option value="">-- Select Recruiter --</option>
                                    @foreach($recruiters as $rec)
                                        <option value="{{ $rec->user_id }}" {{ $employee->ref_emp_id == $rec->user_id ? 'selected' : '' }}>{{ $rec->first_name }} {{ $rec->last_name }} ({{ $rec->employee_id }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 source-field" id="field_vendor" style="{{ $employee->employee_source == 'Vendor' ? '' : 'display: none;' }}">
                                <label class="form-label small fw-bold text-muted">Select Vendor</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3" name="ref_emp_id_ven">
                                    <option value="">-- Select Vendor --</option>
                                    @foreach($vendors as $ven)
                                        <option value="{{ $ven->vendor_id }}" {{ $employee->ref_emp_id == $ven->vendor_id ? 'selected' : '' }}>{{ $ven->vendor_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Has Rejoined</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3" name="has_rejoined">
                                    <option value="No" {{ $employee->has_rejoined == 'No' ? 'selected' : '' }}>No</option>
                                    <option value="Yes" {{ $employee->has_rejoined == 'Yes' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Rejoin Mapping</label>
                                <select class="form-select bg-light border-0 py-2 rounded-3" name="rejoin_emp_id">
                                    <option value="">-- No Mapping --</option>
                                    @foreach($managers as $mgr)
                                        <option value="{{ $mgr->user_id }}" {{ $employee->rejoin_emp_id == $mgr->user_id ? 'selected' : '' }}>{{ $mgr->first_name }} {{ $mgr->last_name }} ({{ $mgr->employee_id }})</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Zone 2: Academic & Career -->
                <div class="tab-pane" id="academic" role="tabpanel" aria-labelledby="academic-tab">
                    <div class="glass-card p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Educational Qualifications</h5>
                            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#qualificationModal" onclick="clearQualModal()">
                                <i class="bi bi-plus-lg me-1"></i> Add New
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm border-0">
                                <thead class="text-muted small text-uppercase">
                                    <tr>
                                        <th>Education Level & Degree</th>
                                        <th>Specialization</th>
                                        <th>Year</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($qualifications as $qual)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $qual->name }}</div>
                                            <div class="x-small text-muted">{{ $education_levels->where('education_level_id', $qual->education_level_id)->first()->name ?? 'General' }}</div>
                                        </td>
                                        <td>{{ $qual->specialization }}</td>
                                        <td>{{ $qual->from_year }} - {{ $qual->to_year }}</td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-link text-primary p-0 me-2" onclick="editQual({{ json_encode($qual) }})">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-link text-danger p-0" onclick="deleteQual({{ $qual->qualification_id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty

                                    <tr><td colspan="3" class="text-center py-3 text-muted">No qualifications recorded.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="glass-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Work Experience</h5>
                            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#experienceModal" onclick="clearExpModal()">
                                <i class="bi bi-plus-lg me-1"></i> Add New
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm border-0">
                                <thead class="text-muted small text-uppercase">
                                    <tr>
                                        <th>Company & Designation</th>
                                        <th>Period</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($work_experience as $exp)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $exp->company_name }}</div>
                                            <div class="x-small text-muted">{{ $exp->post }}</div>
                                        </td>
                                        <td>{{ $exp->from_date }} - {{ $exp->to_date }}</td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-link text-primary p-0 me-2" onclick="editExp({{ json_encode($exp) }})">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-link text-danger p-0" onclick="deleteExp({{ $exp->work_experience_id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="text-center py-3 text-muted">No experience history.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Zone 3: Performance Hub -->
                <div class="tab-pane" id="performance" role="tabpanel" aria-labelledby="performance-tab">
                    <div class="glass-card p-4">
                        <h5 class="fw-bold mb-4">Performance Documents (KRA/KPI)</h5>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light text-center">
                                    <i class="bi bi-file-earmark-check fs-2 text-primary mb-2"></i>
                                    <div class="fw-bold small">KRA Document</div>
                                    @if($employee->kra_doc)
                                        <a href="{{ asset('storage/docs/'.$employee->kra_doc) }}" class="btn btn-sm btn-link text-decoration-none p-0 mt-1" target="_blank">View File</a>
                                    @endif
                                    <input type="file" name="kra_doc" class="form-control form-control-sm mt-2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light text-center">
                                    <i class="bi bi-graph-up-arrow fs-2 text-success mb-2"></i>
                                    <div class="fw-bold small">KPI Framework</div>
                                    @if($employee->kpi_doc)
                                        <a href="{{ asset('storage/docs/'.$employee->kpi_doc) }}" class="btn btn-sm btn-link text-decoration-none p-0 mt-1" target="_blank">View File</a>
                                    @endif
                                    <input type="file" name="kpi_doc" class="form-control form-control-sm mt-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Zone 4: Compliance & Finance -->
                <div class="tab-pane" id="compliance" role="tabpanel" aria-labelledby="compliance-tab">
                    <div class="glass-card p-4 mb-4">
                        <h5 class="fw-bold mb-4">Acceptance Forms (Policies)</h5>
                        <div class="row g-3">
                            @forelse($acceptance_forms as $form)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-4">
                                            <img src="{{ $form->image ? asset('storage/announcements/'.$form->image) : 'https://placehold.co/400x400?text=Policy' }}" class="img-fluid h-100 object-fit-cover">
                                        </div>
                                        <div class="col-8 p-3">
                                            <h6 class="fw-bold mb-1">{{ $form->title }}</h6>
                                            <p class="x-small text-muted mb-2">Submitted: {{ \Carbon\Carbon::parse($form->created_at ?: $form->legacy_created_at)->format('M d, Y') }} ({{ \Carbon\Carbon::parse($form->created_at ?: $form->legacy_created_at)->diffForHumans() }})</p>
                                            <button type="button" class="btn btn-sm btn-light text-primary rounded-pill px-3" onclick="window.print()">
                                                <i class="bi bi-printer me-1"></i> Print
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-4 text-muted">No accepted forms found.</div>
                            @endforelse
                        </div>
                    </div>
                    <div class="glass-card p-4">
                        <h5 class="fw-bold mb-4">Reimbursement History</h5>
                        <div class="table-responsive">
                            <table class="table table-hover border-0">
                                <thead class="text-muted small">
                                    <tr>
                                        <th>Certificate</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reimbursements as $rem)
                                    <tr>
                                        <td class="fw-bold">{{ $rem->certificate_name }}</td>
                                        <td>{{ $rem->reimburse_amount_req }}</td>
                                        <td>
                                            <span class="badge bg-light text-{{ $rem->show_status == 1 ? 'success' : 'warning' }} rounded-pill px-3">
                                                {{ $rem->show_status == 1 ? 'Approved' : 'Pending' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="text-center py-3 text-muted">No reimbursement records.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Zone 5: Security & Verification -->
                <div class="tab-pane" id="security" role="tabpanel" aria-labelledby="security-tab">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="glass-card h-100 p-4">
                                <h5 class="fw-bold mb-4">Account Security</h5>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">New Password</label>
                                    <input type="password" name="password" class="form-control bg-light border-0 py-2 rounded-3" placeholder="Leave blank to keep same">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control bg-light border-0 py-2 rounded-3">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="glass-card h-100 p-4 shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-bold mb-0">Emergency Contacts</h5>
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#contactModal" onclick="clearContactModal()">
                                        <i class="bi bi-plus-lg me-1"></i> Add New
                                    </button>
                                </div>
                                <div class="list-group list-group-flush">
                                    @forelse($emergency_contacts as $contact)
                                    <div class="list-group-item bg-transparent border-0 px-0 pb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fw-bold mb-0 small">{{ $contact->contact_name }} <span class="badge bg-light text-primary rounded-pill ms-2 fw-normal">{{ $contact->relation }}</span></h6>
                                                <div class="x-small text-muted mt-1">
                                                    <i class="bi bi-telephone me-1"></i> {{ $contact->mobile_phone }}
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-light rounded-circle p-2 text-primary" onclick="editContact({{ json_encode($contact) }})" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-light rounded-circle p-2 text-danger" onclick="deleteContact({{ $contact->contact_id }})" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-4 text-muted">
                                        <i class="bi bi-person-lines-fill fs-2 d-block mb-2 opacity-50"></i>
                                        No emergency contacts listed.
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Zone 6: Social Connect -->
                <div class="tab-pane" id="social" role="tabpanel" aria-labelledby="social-tab">
                    <div class="glass-card p-4">
                        <h5 class="fw-bold mb-4">Digital Identity</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">LinkedIn Profile</label>
                                <input type="url" class="form-control bg-light border-0 py-2 rounded-3" name="linkdedin_link" value="{{ $employee->linkdedin_link }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Facebook Profile</label>
                                <input type="url" class="form-control bg-light border-0 py-2 rounded-3" name="facebook_link" value="{{ $employee->facebook_link }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Global Actions -->
            <div class="glass-card mt-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $employee->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold">Account Active</label>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow" id="globalSaveBtn">
                        <i class="bi bi-check-circle me-1"></i> Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Qualification Modal -->
<div class="modal fade" id="qualificationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form id="qualForm">
                @csrf
                <input type="hidden" name="qualification_id" id="qual_id">
                <input type="hidden" name="employee_id" value="{{ $employee->user_id }}">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Academic Qualification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Education Level</label>
                            <select class="form-select bg-light border-0 py-2 rounded-3" name="education_level_id" id="qual_level" required>
                                @foreach($education_levels as $level)
                                    <option value="{{ $level->education_level_id }}">{{ $level->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Degree / Certification Name</label>
                            <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="name" id="qual_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Specialization</label>
                            <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="specialization" id="qual_specialization">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">From Year</label>
                            <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="from_year" id="qual_from">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">To Year</label>
                            <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="to_year" id="qual_to">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Description / Notes</label>
                            <textarea class="form-control bg-light border-0 py-2 rounded-3" name="description" id="qual_desc" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-save me-1"></i> Save Qualification
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Experience Modal -->
<div class="modal fade" id="experienceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form id="expForm">
                @csrf
                <input type="hidden" name="work_experience_id" id="exp_id">
                <input type="hidden" name="employee_id" value="{{ $employee->user_id }}">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Work Experience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Company Name</label>
                            <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="company_name" id="exp_company" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Designation / Post</label>
                            <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="post" id="exp_post" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">From Date</label>
                            <input type="date" class="form-control bg-light border-0 py-2 rounded-3" name="from_date" id="exp_from" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">To Date</label>
                            <input type="date" class="form-control bg-light border-0 py-2 rounded-3" name="to_date" id="exp_to" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Work Description</label>
                            <textarea class="form-control bg-light border-0 py-2 rounded-3" name="description" id="exp_desc" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-save me-1"></i> Save Experience
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Emergency Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form id="contactForm">
                @csrf
                <input type="hidden" name="contact_id" id="contact_id_field">
                <input type="hidden" name="employee_id" value="{{ $employee->user_id }}">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Emergency Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Contact Name</label>
                            <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="contact_name" id="contact_name_field" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Relationship</label>
                            <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="relation" id="contact_relation" placeholder="e.g. Spouse" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Mobile Phone</label>
                            <input type="text" class="form-control bg-light border-0 py-2 rounded-3" name="mobile_phone" id="contact_phone" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" class="form-control bg-light border-0 py-2 rounded-3" name="personal_email" id="contact_email">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Full Address</label>
                            <textarea class="form-control bg-light border-0 py-2 rounded-3" name="address_1" id="contact_address" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-save me-1"></i> Save Contact
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function clearQualModal() { $('#qualForm')[0].reset(); $('#qual_id').val(''); }
    function editQual(data) {
        clearQualModal();
        $('#qual_id').val(data.qualification_id);
        $('#qual_level').val(data.education_level_id);
        $('#qual_name').val(data.name);
        $('#qual_specialization').val(data.specialization);
        $('#qual_from').val(data.from_year);
        $('#qual_to').val(data.to_year);
        $('#qual_desc').val(data.description);
        $('#qualificationModal').modal('show');
    }
    
    function clearExpModal() { $('#expForm')[0].reset(); $('#exp_id').val(''); }
    function editExp(data) {
        clearExpModal();
        $('#exp_id').val(data.work_experience_id);
        $('#exp_company').val(data.company_name);
        $('#exp_post').val(data.post);
        $('#exp_from').val(data.from_date);
        $('#exp_to').val(data.to_date);
        $('#exp_desc').val(data.description);
        $('#experienceModal').modal('show');
    }

    function clearContactModal() { $('#contactForm')[0].reset(); $('#contact_id_field').val(''); }
    function editContact(data) {
        clearContactModal();
        $('#contact_id_field').val(data.contact_id);
        $('#contact_name_field').val(data.contact_name);
        $('#contact_relation').val(data.relation);
        $('#contact_phone').val(data.mobile_phone);
        $('#contact_email').val(data.personal_email);
        $('#contact_address').val(data.address_1);
        $('#contactModal').modal('show');
    }

    $(document).ready(function() {
        // Initialize Select2 for all searchable dropdowns
        $('.form-select').select2({
            width: '100%',
            dropdownParent: $('#editEmployeeForm')
        });

        // Profile Tab Switcher JS
        // Generic AJAX Submission Helper
        function handleSubRecordSubmit(formId, url, modalId) {
            $(`#${formId}`).on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $(`#${modalId}`).modal('hide');
                        Swal.fire('Success', response.success, 'success').then(() => location.reload());
                    },
                    error: function() { Swal.fire('Error', 'Failed to save record', 'error'); }
                });
            });
        }

        handleSubRecordSubmit('qualForm', "{{ route('save.qualification') }}", 'qualificationModal');
        handleSubRecordSubmit('expForm', "{{ route('save.experience') }}", 'experienceModal');
        handleSubRecordSubmit('contactForm', "{{ route('save.contact') }}", 'contactModal');

        // Delete Handlers
        window.deleteQual = (id) => confirmDelete(id, "{{ url('delete-qualification') }}");
        window.deleteExp = (id) => confirmDelete(id, "{{ url('delete-experience') }}");
        window.deleteContact = (id) => confirmDelete(id, "{{ url('delete-contact') }}");

        function confirmDelete(id, url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This removal cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${url}/${id}`,
                        type: 'DELETE',
                        data: { _token: "{{ csrf_token() }}" },
                        success: function(response) {
                            Swal.fire('Deleted!', response.success, 'success').then(() => location.reload());
                        }
                    });
                }
            });
        }

        // Image Preview
        $('#profile_picture').on('change', function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) { $('#avatarPreview').attr('src', event.target.result); }
                reader.readAsDataURL(file);
            }
        });

        // Employee Source Recruiter toggle
        // Employee Source and Referral Field Logic
        $('#employeeSourceSelect').on('change', function() {
            const val = $(this).val();
            $('.source-field').hide().find('select').val('').trigger('change'); // Reset and hide all
            
            if (['Reference', 'Referral'].includes(val)) {
                $('#field_referral').fadeIn();
            } else if (['Recruiter', 'Job Board'].includes(val)) {
                $('#field_recruiter').fadeIn();
            } else if (val === 'Vendor') {
                $('#field_vendor').fadeIn();
            }
        });


        // Cascading Dropdowns
        $('.cascading-comp').on('change', function() {
            let company_id = $(this).val();
            $('.cascading-dept').html('<option value="">Loading...</option>');
            $.get("{{ url('get-departments') }}/" + company_id, function(data) {
                let html = '<option value="">-- Select --</option>';
                data.forEach(item => html += `<option value="${item.department_id}">${item.department_name}</option>`);
                $('.cascading-dept').html(html).trigger('change');
            });
        });

        $('.cascading-dept').on('change', function() {
            let department_id = $(this).val();
            // Refresh designations
            $('.cascading-desig').html('<option value="">Loading...</option>');
            $.get("{{ url('get-designations') }}/" + department_id, function(data) {
                let html = '<option value="">-- Select --</option>';
                data.forEach(item => html += `<option value="${item.designation_id}">${item.designation_name}</option>`);
                $('.cascading-desig').html(html);
            });
            // Refresh sub-departments
            $('.cascading-sub-dept').html('<option value="">Loading...</option>');
            $.get("{{ url('get-sub-departments') }}/" + department_id, function(data) {
                let html = '<option value="">-- Select Sub Department --</option>';
                data.forEach(item => html += `<option value="${item.sub_department_id}">${item.department_name}</option>`);
                $('.cascading-sub-dept').html(html);
            });
        });

        // Global Update
        $('#editEmployeeForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#globalSaveBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');
            $.ajax({
                url: "{{ route('employees.update', $employee->user_id) }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) { Swal.fire('Success', response.success, 'success'); },
                error: function(xhr) {
                    let errorMessage = 'Update failed. Please check the form and try again.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: 'Validation Error',
                        html: errorMessage,
                        icon: 'error'
                    });
                },
                complete: function() { $('#globalSaveBtn').prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i> Save Changes'); }
            });
        });
    });
</script>
@endpush
