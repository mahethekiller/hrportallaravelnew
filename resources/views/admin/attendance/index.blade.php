@extends('layouts.admin')

@section('page_title', 'Attendance Timeline')

@section('content')
<style>
    .date-leaf {
        width: 60px;
        height: 60px;
        background: rgba(var(--bs-primary-rgb), 0.1);
        border: 1px solid rgba(var(--bs-primary-rgb), 0.2);
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .date-leaf .month {
        font-size: 0.65rem;
        font-weight: 800;
        text-uppercase: uppercase;
        color: var(--bs-primary);
        line-height: 1;
    }
    .date-leaf .day {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--bs-primary);
        line-height: 1.1;
    }

    .attendance-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    .attendance-card:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    .avatar-initial {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--bs-primary), #6366f1);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: 700;
        font-size: 0.85rem;
        box-shadow: 0 4px 10px rgba(var(--bs-primary-rgb), 0.3);
    }

    .timeline-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 10px;
        position: relative;
    }
    .timeline-dot::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        width: 2px;
        height: 20px;
        background: rgba(0,0,0,0.05);
        transform: translateX(-50%);
    }
    [data-theme="dark"] .timeline-dot::after {
        background: rgba(255,255,255,0.05);
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .empty-state {
        padding: 5rem 2rem;
        text-align: center;
        opacity: 0.6;
    }
</style>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">Attendance Timeline</h4>
            <p class="text-muted mb-0 small">Modern activity tracking and daily logs.</p>
        </div>
    </div>
</div>

<div class="glass-card mb-4">
    <form id="attendanceFilterForm">
        <div class="row align-items-end">
            @if(count($employees) > 1 || auth()->user()->can('view_all_attendance'))
            <div class="col-md-3 mb-3">
                <label class="form-label small fw-semibold text-muted">Employee</label>
                <select name="employee_id" id="employee_id" class="form-select bg-light border-0 py-2 rounded-3">
                    @foreach($employees as $emp)
                        <option value="{{ $emp->user_id }}" {{ $emp->user_id == auth()->user()->user_id ? 'selected' : '' }}>
                            {{ $emp->first_name }} {{ $emp->last_name }} ({{ $emp->employee_id }})
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="col-md-3 mb-3">
                <label class="form-label small fw-semibold text-muted">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control bg-light border-0 py-2 rounded-3" value="{{ date('Y-m-d') }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label small fw-semibold text-muted">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control bg-light border-0 py-2 rounded-3" value="{{ date('Y-m-d') }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <button type="button" class="btn btn-primary w-100 shadow-sm py-2" id="getAttendanceBtn" onclick="refreshTimeline()">
                    <i class="bi bi-funnel me-1"></i> Filter Logs
                </button>
            </div>
        </div>
    </form>
</div>

<div id="attendanceTimeline" class="row row-cols-1 row-cols-md-2 g-3">
    <div class="col-12 empty-state">
        <div class="spinner-border text-primary mb-3"></div>
        <p>Loading your attendance timeline...</p>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        refreshTimeline();
    });

    function refreshTimeline() {
        let btn = $('#getAttendanceBtn');
        let originalText = btn.html();
        btn.html('<span class="spinner-border spinner-border-sm"></span> Loading...').prop('disabled', true);
        
        const data = {
            employee_id: $('#employee_id').val(),
            start_date: $('#start_date').val(),
            end_date: $('#end_date').val(),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: "{{ route('attendance.data') }}",
            type: 'POST',
            data: data,
            success: function(response) {
                renderTimeline(response.data);
                btn.html(originalText).prop('disabled', false);
            },
            error: function() {
                $('#attendanceTimeline').html('<div class="empty-state"><i class="bi bi-exclamation-triangle h1 text-danger"></i><p>Failed to load attendance records.</p></div>');
                btn.html(originalText).prop('disabled', false);
            }
        });
    }

    function renderTimeline(data) {
        let container = $('#attendanceTimeline');
        container.empty();

        if (!data || data.length === 0) {
            container.html('<div class="empty-state"><i class="bi bi-calendar-x h1"></i><p>No attendance records found for the selected period.</p></div>');
            return;
        }

        data.forEach(item => {
            let statusColor = 'danger';
            let statusIcon = 'bi-x-circle';
            
            if (item.status === 'Present') { statusColor = 'success'; statusIcon = 'bi-check-circle-fill'; }
            else if (item.status === 'Holiday') { statusColor = 'info'; statusIcon = 'bi-calendar-event'; }
            else if (item.status === 'On Leave') { statusColor = 'warning'; statusIcon = 'bi-briefcase'; }

            const card = `
                <div class="col">
                    <div class="attendance-card glass-card p-3 h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="date-leaf">
                                <span class="month">${item.month_short}</span>
                                <span class="day">${item.date_short}</span>
                            </div>
                            
                            <div class="flex-grow-1">
                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-initial">${item.initials}</div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">${item.employee_name}</h6>
                                            <small class="text-muted">${item.day}</small>
                                        </div>
                                    </div>
                                    <span class="status-badge bg-${statusColor}-subtle text-${statusColor} border border-${statusColor}-subtle">
                                        <i class="bi ${statusIcon} me-1"></i> ${item.status}
                                    </span>
                                </div>
                                
                                <hr class="my-2 opacity-5">
                                
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block small fw-semibold text-uppercase" style="font-size: 0.6rem;">Clock In</small>
                                        <span class="fw-bold small"><i class="bi bi-box-arrow-in-right text-success me-1"></i> ${item.clock_in}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block small fw-semibold text-uppercase" style="font-size: 0.6rem;">Clock Out</small>
                                        <span class="fw-bold small"><i class="bi bi-box-arrow-right text-primary me-1"></i> ${item.clock_out}</span>
                                    </div>
                                    <div class="col-12 mt-2 text-end">
                                        <small class="text-muted d-block small fw-semibold text-uppercase" style="font-size: 0.6rem;">Daily Total</small>
                                        <span class="h6 mb-0 text-primary fw-800">${item.total_work}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.append(card);
        });
    }
</script>
@endpush
