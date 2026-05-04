@extends("layouts.app")

@section("title", "Appointments — WellMeadows HMS")
@section("page_title", "Appointments")

@section("content")
<div class="container-fluid px-0">

    <!-- KPI Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-between align-items-center rounded-4">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.78rem;">Total Today</p>
                    <h3 class="fs-2 fw-bold mb-0">{{ $stats['total_today'] }}</h3>
                </div>
                <div style="width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:rgba(99,102,241,0.1);">
                    <i class="bi bi-calendar-check" style="font-size:1.3rem;color:#6366F1;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-between align-items-center rounded-4">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.78rem;">Completed</p>
                    <h3 class="fs-2 fw-bold mb-0">{{ $stats['completed'] }}</h3>
                </div>
                <div style="width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:rgba(16,185,129,0.1);">
                    <i class="bi bi-check-circle" style="font-size:1.3rem;color:#10B981;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-between align-items-center rounded-4">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.78rem;">Upcoming</p>
                    <h3 class="fs-2 fw-bold mb-0">{{ $stats['upcoming'] }}</h3>
                </div>
                <div style="width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:rgba(245,158,11,0.1);">
                    <i class="bi bi-clock" style="font-size:1.3rem;color:#F59E0B;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-between align-items-center rounded-4">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.78rem;">Cancelled</p>
                    <h3 class="fs-2 fw-bold mb-0">{{ $stats['cancelled'] }}</h3>
                </div>
                <div style="width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:rgba(239,68,68,0.1);">
                    <i class="bi bi-x-circle" style="font-size:1.3rem;color:#EF4444;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex gap-2">
            <a href="{{ route('appointments.create') }}" class="btn btn-primary px-4"><i class="bi bi-calendar-plus me-2"></i>New Appointment</a>
        </div>
        <form method="GET" action="{{ route('appointments.index') }}" class="m-0">
            <div class="input-group shadow-sm rounded" style="max-width:280px;">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 ps-0" placeholder="Search appointments...">
            </div>
        </form>
    </div>

    <!-- Appointments Table -->
    <div class="card border-0 rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Appt No</th>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Exam Room</th>
                        <th>Staff</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                    <tr>
                        <td class="fw-medium text-dark px-4">{{ $appt->appointment_no }}</td>
                        <td>
                            @if($appt->patient)
                                <div class="d-flex align-items-center gap-2">
                                    @php
                                        $fullName = $appt->patient->first_name . ' ' . $appt->patient->last_name;
                                        $colors = ['6366F1', '10B981', 'F59E0B', 'EC4899', '8B5CF6'];
                                        $color = $colors[crc32($appt->patient->patient_no) % count($colors)];
                                    @endphp
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($fullName) }}&background={{ $color }}&color=fff&size=32" class="rounded-circle" width="32" height="32">
                                    <div>
                                        <div class="fw-bold" style="font-size:0.85rem;">{{ $fullName }}</div>
                                        <div class="text-muted" style="font-size:0.72rem;">{{ $appt->patient_no }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">Unknown Patient</span>
                            @endif
                        </td>
                        <td style="font-size:0.85rem;">{{ \Carbon\Carbon::parse($appt->date_of_appointment)->format('d-M-y') }}</td>
                        <td style="font-size:0.85rem;">{{ \Carbon\Carbon::parse($appt->time_of_appointment)->format('H:i') }}</td>
                        <td><span class="badge bg-secondary rounded-pill">{{ $appt->examination_room }}</span></td>
                        <td style="font-size:0.85rem;">
                            @if($appt->staff)
                                {{ $appt->staff->first_name }} {{ $appt->staff->last_name }}
                            @else
                                Unknown
                            @endif
                        </td>
                        <td>
                            @if($appt->status == 'Completed')
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Completed</span>
                            @elseif($appt->status == 'Scheduled')
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Scheduled</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">{{ $appt->status }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <!-- Currently no show view, let's link edit directly or we can have a show route -->
                            <a href="{{ route('appointments.edit', $appt->appointment_no) }}" class="btn btn-sm btn-light text-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('appointments.destroy', $appt->appointment_no) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger" title="Cancel/Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No appointments found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($appointments->hasPages())
        <div class="card-footer bg-white border-0 py-3 px-4">
            {{ $appointments->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
