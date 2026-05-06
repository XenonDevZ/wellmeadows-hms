@extends('layouts.app')
@section('title', 'Appointments Report — WellMeadows HMS')
@section('page_title', 'Appointments Report')

@section('content')
<style>
@media print {
    .no-print { display: none !important; }
    .card { box-shadow: none !important; border: 1px solid #dee2e6 !important; }
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <a href="{{ route('reports.index') }}" class="btn btn-light"><i class="bi bi-arrow-left me-2"></i>Back to Reports</a>
    <button onclick="window.print()" class="btn btn-warning px-4"><i class="bi bi-printer me-2"></i>Print Report</button>
</div>

<div class="card border-0 rounded-4 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h4 class="fw-bold mb-1">Appointments Report</h4>
                <p class="text-muted small mb-0">WellMeadows Hospital — Generated {{ now()->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-end">
                <div class="fw-bold text-warning" style="font-size:1.4rem">{{ $appointments->count() }}</div>
                <div class="text-muted small">Total Appointments</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 rounded-4 text-center p-3">
            <div class="fw-bold fs-4 text-primary">{{ $totalScheduled }}</div>
            <div class="text-muted small">Scheduled</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 rounded-4 text-center p-3">
            <div class="fw-bold fs-4 text-success">{{ $totalCompleted }}</div>
            <div class="text-muted small">Completed</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 rounded-4 text-center p-3">
            <div class="fw-bold fs-4 text-danger">{{ $totalCancelled }}</div>
            <div class="text-muted small">Cancelled</div>
        </div>
    </div>
</div>

<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr>
                    <th class="px-4">Appt No</th><th>Patient</th><th>Doctor</th><th>Date & Time</th><th>Room</th><th>Status</th>
                </tr></thead>
                <tbody>
                @forelse($appointments as $appt)
                @php
                    $pname = $appt->patient ? $appt->patient->first_name.' '.$appt->patient->last_name : 'Unknown';
                    $dname = $appt->staff ? $appt->staff->first_name.' '.$appt->staff->last_name : 'Unknown';
                @endphp
                <tr>
                    <td class="fw-medium px-4">{{ $appt->appointment_no }}</td>
                    <td>
                        <div class="fw-bold" style="font-size:.85rem">{{ $pname }}</div>
                        <div class="text-muted" style="font-size:.72rem">{{ $appt->patient_no }}</div>
                    </td>
                    <td style="font-size:.85rem">{{ $dname }}</td>
                    <td style="font-size:.85rem">
                        {{ \Carbon\Carbon::parse($appt->date_of_appointment)->format('d M Y') }}
                        <div class="text-muted" style="font-size:.72rem">{{ \Carbon\Carbon::parse($appt->time_of_appointment)->format('H:i') }}</div>
                    </td>
                    <td style="font-size:.85rem">{{ $appt->examination_room }}</td>
                    <td>
                        @if($appt->status == 'Completed')
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Completed</span>
                        @elseif($appt->status == 'Cancelled')
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Cancelled</span>
                        @else
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">Scheduled</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">No appointment records found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
