@extends('layouts.app')
@section('title', 'Requisitions Report — WellMeadows HMS')
@section('page_title', 'Ward Requisitions Report')

@section('content')
<style>
@media print {
    .no-print { display: none !important; }
    .card { box-shadow: none !important; border: 1px solid #dee2e6 !important; }
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <a href="{{ route('reports.index') }}" class="btn btn-light"><i class="bi bi-arrow-left me-2"></i>Back to Reports</a>
    <button onclick="window.print()" class="btn px-4" style="background:#EC4899;color:#fff"><i class="bi bi-printer me-2"></i>Print Report</button>
</div>

<div class="card border-0 rounded-4 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h4 class="fw-bold mb-1">Ward Requisitions Report</h4>
                <p class="text-muted small mb-0">WellMeadows Hospital — Generated {{ now()->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-end">
                <div class="fw-bold" style="font-size:1.4rem;color:#EC4899">{{ $requisitions->count() }}</div>
                <div class="text-muted small">Total Requisitions</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 rounded-4 text-center p-3">
            <div class="fw-bold fs-4 text-warning">{{ $totalPending }}</div>
            <div class="text-muted small">Pending</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 rounded-4 text-center p-3">
            <div class="fw-bold fs-4 text-success">{{ $totalApproved }}</div>
            <div class="text-muted small">Approved</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 rounded-4 text-center p-3">
            <div class="fw-bold fs-4 text-info">{{ $totalDelivered }}</div>
            <div class="text-muted small">Delivered</div>
        </div>
    </div>
</div>

<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr>
                    <th class="px-4">Req No</th><th>Ward</th><th>Requested By</th><th>Date</th><th>Items</th><th>Status</th>
                </tr></thead>
                <tbody>
                @forelse($requisitions as $req)
                <tr>
                    <td class="fw-medium px-4">{{ $req->requisition_no }}</td>
                    <td style="font-size:.85rem">{{ $req->ward ? $req->ward->ward_name : '—' }}</td>
                    <td style="font-size:.85rem">{{ $req->staff ? $req->staff->first_name.' '.$req->staff->last_name : '—' }}</td>
                    <td style="font-size:.85rem">{{ $req->date_ordered ? \Carbon\Carbon::parse($req->date_ordered)->format('d M Y') : '—' }}</td>
                    <td>
                        @if($req->items->count() > 0)
                            <ul class="mb-0 ps-3" style="font-size:.78rem">
                                @foreach($req->items as $item)
                                    <li>{{ $item->name }} (×{{ $item->pivot->quantity_required }})</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted small">No items</span>
                        @endif
                    </td>
                    <td>
                        @if($req->status == 'Approved')
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Approved</span>
                        @elseif($req->status == 'Delivered')
                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">Delivered</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Pending</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">No requisition records found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
