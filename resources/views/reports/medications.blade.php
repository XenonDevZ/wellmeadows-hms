@extends('layouts.app')
@section('title', 'Medications Report — WellMeadows HMS')
@section('page_title', 'Patient Medications Report')

@section('content')
<style>
@media print {
    .no-print { display: none !important; }
    .card { box-shadow: none !important; border: 1px solid #dee2e6 !important; }
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <a href="{{ route('reports.index') }}" class="btn btn-light"><i class="bi bi-arrow-left me-2"></i>Back to Reports</a>
    <button onclick="window.print()" class="btn px-4" style="background:#8B5CF6;color:#fff"><i class="bi bi-printer me-2"></i>Print Report</button>
</div>

<div class="card border-0 rounded-4 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h4 class="fw-bold mb-1">Patient Medications Report</h4>
                <p class="text-muted small mb-0">WellMeadows Hospital — Generated {{ now()->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-end">
                <div class="fw-bold" style="font-size:1.4rem;color:#8B5CF6">{{ $medications->count() }}</div>
                <div class="text-muted small">Total Prescriptions</div>
            </div>
        </div>
    </div>
</div>

@if($medications->count() > 0)
<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr>
                    <th class="px-4">Patient</th><th>Medication</th><th>Dosage</th><th>Frequency</th><th>Start Date</th><th>End Date</th>
                </tr></thead>
                <tbody>
                @foreach($medications as $med)
                <tr>
                    <td class="px-4">
                        <div class="fw-bold" style="font-size:.85rem">{{ $med->patient ? $med->patient->first_name.' '.$med->patient->last_name : 'Unknown' }}</div>
                        <div class="text-muted" style="font-size:.72rem">{{ $med->patient_no }}</div>
                    </td>
                    <td style="font-size:.85rem">{{ $med->medication ? $med->medication->name : '—' }}</td>
                    <td style="font-size:.85rem">{{ $med->medication ? $med->medication->dosage : '—' }}</td>
                    <td style="font-size:.85rem">{{ $med->units_per_day ? $med->units_per_day.' units/day' : '—' }}</td>
                    <td style="font-size:.85rem">{{ $med->start_date ? \Carbon\Carbon::parse($med->start_date)->format('d M Y') : '—' }}</td>
                    <td style="font-size:.85rem">{{ $med->end_date ? \Carbon\Carbon::parse($med->end_date)->format('d M Y') : 'Ongoing' }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body text-center py-5">
        <i class="bi bi-capsule text-muted" style="font-size:3rem;color:#8B5CF6;opacity:.4"></i>
        <h6 class="fw-bold mt-3 mb-1">No Prescriptions on Record</h6>
        <p class="text-muted small mb-0">Patient medication records will appear here once prescriptions are added to the system.</p>
    </div>
</div>
@endif
@endsection
