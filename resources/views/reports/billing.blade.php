@extends('layouts.app')
@section('title', 'Billing Report — WellMeadows HMS')
@section('page_title', 'Patient Billing Report')

@section('content')
<style>
@media print {
    .no-print { display: none !important; }
    .card { box-shadow: none !important; border: 1px solid #dee2e6 !important; }
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <a href="{{ route('reports.index') }}" class="btn btn-light"><i class="bi bi-arrow-left me-2"></i>Back to Reports</a>
    <button onclick="window.print()" class="btn btn-success px-4"><i class="bi bi-printer me-2"></i>Print Report</button>
</div>

<div class="card border-0 rounded-4 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h4 class="fw-bold mb-1">Patient Billing Report</h4>
                <p class="text-muted small mb-0">WellMeadows Hospital — Generated {{ now()->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-end">
                <div class="fw-bold text-success" style="font-size:1.4rem">£{{ number_format($totalAmount, 2) }}</div>
                <div class="text-muted small">Total Billed</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 rounded-4 text-center p-3">
            <div class="fw-bold fs-4">{{ $bills->count() }}</div>
            <div class="text-muted small">Total Bills</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 rounded-4 text-center p-3">
            <div class="fw-bold fs-4 text-success">£{{ number_format($totalPaid, 2) }}</div>
            <div class="text-muted small">Collected ({{ $paidCount }} bills)</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 rounded-4 text-center p-3">
            <div class="fw-bold fs-4 text-danger">£{{ number_format($totalUnpaid, 2) }}</div>
            <div class="text-muted small">Outstanding ({{ $unpaidCount }} bills)</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 rounded-4 text-center p-3">
            @php $rate = $bills->count() > 0 ? round(($paidCount / $bills->count()) * 100) : 0; @endphp
            <div class="fw-bold fs-4 text-primary">{{ $rate }}%</div>
            <div class="text-muted small">Collection Rate</div>
        </div>
    </div>
</div>

<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr>
                    <th class="px-4">Bill No</th><th>Patient</th><th>Date</th><th>Amount</th><th>Status</th>
                </tr></thead>
                <tbody>
                @forelse($bills as $bill)
                @php $pname = $bill->patient ? $bill->patient->first_name.' '.$bill->patient->last_name : 'Unknown'; @endphp
                <tr>
                    <td class="fw-medium px-4">{{ $bill->bill_no }}</td>
                    <td>
                        <div class="fw-bold" style="font-size:.85rem">{{ $pname }}</div>
                        <div class="text-muted" style="font-size:.72rem">{{ $bill->patient_no }}</div>
                    </td>
                    <td style="font-size:.85rem">{{ $bill->bill_date ? \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') : '—' }}</td>
                    <td class="fw-bold" style="font-size:.85rem">£{{ number_format($bill->total_amount, 2) }}</td>
                    <td>
                        @if($bill->status == 'Paid')
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Paid</span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Unpaid</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4 text-muted">No billing records found.</td></tr>
                @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="3" class="px-4 fw-bold text-end">Total</td>
                        <td class="fw-bold">£{{ number_format($totalAmount, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
