@extends('layouts.app')
@section('title', 'Ward Allocation Report — WellMeadows HMS')
@section('page_title', 'Ward Allocation Report')

@section('content')
<style>
@media print {
    .no-print { display: none !important; }
    .card { box-shadow: none !important; border: 1px solid #dee2e6 !important; }
    body { font-size: 12px; }
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <a href="{{ route('reports.index') }}" class="btn btn-light"><i class="bi bi-arrow-left me-2"></i>Back to Reports</a>
    <button onclick="window.print()" class="btn btn-primary px-4"><i class="bi bi-printer me-2"></i>Print Report</button>
</div>

{{-- Report Header --}}
<div class="card border-0 rounded-4 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h4 class="fw-bold mb-1">Ward Allocation Report</h4>
                <p class="text-muted small mb-0">WellMeadows Hospital — Generated {{ now()->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-end">
                <div class="fw-bold text-primary" style="font-size:1.4rem">{{ $totalAdmitted }}</div>
                <div class="text-muted small">Currently Admitted</div>
            </div>
        </div>
    </div>
</div>

{{-- KPI Row --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 rounded-4 text-center p-3">
            <div class="fw-bold fs-4 text-primary">{{ $totalAdmitted }}</div>
            <div class="text-muted small">Patients in Ward</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 rounded-4 text-center p-3">
            <div class="fw-bold fs-4 text-warning">{{ $totalWaiting }}</div>
            <div class="text-muted small">On Waiting List</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 rounded-4 text-center p-3">
            <div class="fw-bold fs-4 text-success">{{ $wards->count() }}</div>
            <div class="text-muted small">Active Wards</div>
        </div>
    </div>
</div>

{{-- Ward Sections --}}
@forelse($wards as $ward)
@if($ward->inPatients->count() > 0)
<div class="card border-0 rounded-4 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3 px-4">
        <div>
            <h6 class="fw-bold mb-0">{{ $ward->ward_name }}</h6>
            <span class="text-muted small">{{ $ward->location }} · Ext. {{ $ward->telephone_extension }}</span>
        </div>
        <div class="text-end">
            <div class="text-muted small">Charge Nurse</div>
            <div class="fw-bold small">{{ $ward->chargeNurse ? $ward->chargeNurse->first_name.' '.$ward->chargeNurse->last_name : '—' }}</div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr>
                    <th class="px-4">Patient</th><th>Bed</th><th>Admitted</th><th>Expected Discharge</th><th>Duration (days)</th><th>Status</th>
                </tr></thead>
                <tbody>
                @foreach($ward->inPatients as $ip)
                @php
                    $pname = $ip->patient ? $ip->patient->first_name.' '.$ip->patient->last_name : 'Unknown';
                    $left = $ip->actual_date_left;
                @endphp
                <tr>
                    <td class="px-4">
                        <div class="fw-bold" style="font-size:.85rem">{{ $pname }}</div>
                        <div class="text-muted" style="font-size:.72rem">{{ $ip->patient_no }}</div>
                    </td>
                    <td style="font-size:.85rem">{{ $ip->bed_no ?? '—' }}</td>
                    <td style="font-size:.85rem">{{ $ip->date_placed_in_ward ? $ip->date_placed_in_ward->format('d M Y') : 'Waiting' }}</td>
                    <td style="font-size:.85rem">{{ $ip->date_expected_to_leave ? $ip->date_expected_to_leave->format('d M Y') : '—' }}</td>
                    <td style="font-size:.85rem">{{ $ip->expected_duration_of_stay }}</td>
                    <td>
                        @if($left)
                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">Discharged</span>
                        @elseif($ip->date_placed_in_ward)
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Admitted</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Waiting</span>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@empty
<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body text-center py-5">
        <i class="bi bi-hospital text-muted" style="font-size:3rem"></i>
        <p class="text-muted mt-3 mb-0">No ward allocation data found.</p>
    </div>
</div>
@endforelse
@endsection
