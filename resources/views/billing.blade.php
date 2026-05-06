@extends("layouts.app")
@section("title", "Billing & Requisition — WellMeadows HMS")
@section("page_title", "Billing & Requisition")
@section("content")
<div class="container-fluid px-0">

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<ul class="nav nav-tabs mb-4 border-0" id="billingTabs">
    <li class="nav-item"><a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#billingTab" style="border-radius:8px 8px 0 0;"><i class="bi bi-receipt me-2"></i>Patient Billing</a></li>
    <li class="nav-item"><a class="nav-link fw-semibold" data-bs-toggle="tab" href="#requisitionTab" style="border-radius:8px 8px 0 0;"><i class="bi bi-box-seam me-2"></i>Ward Requisitions</a></li>
    <li class="nav-item"><a class="nav-link fw-semibold" data-bs-toggle="tab" href="#supplierTab" style="border-radius:8px 8px 0 0;"><i class="bi bi-truck me-2"></i>Suppliers & Stock</a></li>
</ul>

<div class="tab-content">

{{-- ── BILLING TAB ──────────────────────────────────────────── --}}
<div class="tab-pane fade show active" id="billingTab">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('billing.create') }}" class="btn btn-primary px-4"><i class="bi bi-plus-circle me-2"></i>Create Bill</a>
        <form method="GET" action="{{ route('billing.index') }}" class="m-0">
            <div class="input-group shadow-sm rounded" style="max-width:280px;">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="bill_search" value="{{ request('bill_search') }}" class="form-control border-start-0 ps-0" placeholder="Search bills...">
            </div>
        </form>
    </div>
    <div class="card border-0 rounded-4 overflow-hidden mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead><tr>
                        <th>Bill No</th><th>Patient</th><th>Date</th><th>Total</th><th>Status</th><th class="text-center">Action</th>
                    </tr></thead>
                    <tbody>
                    @forelse($bills as $bill)
                    @php
                        $bname = $bill->patient ? $bill->patient->first_name.' '.$bill->patient->last_name : 'Unknown';
                        $colors = ['6366F1','10B981','F59E0B','EC4899','8B5CF6'];
                        $bc = $colors[crc32($bill->patient_no ?? 'x') % 5];
                    @endphp
                    <tr>
                        <td class="fw-medium px-4">{{ $bill->bill_no }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($bname) }}&background={{ $bc }}&color=fff&size=32" class="rounded-circle" width="32" height="32">
                                <div>
                                    <div class="fw-bold" style="font-size:.85rem">{{ $bname }}</div>
                                    <div class="text-muted" style="font-size:.72rem">{{ $bill->patient_no }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:.85rem">{{ $bill->bill_date ? \Carbon\Carbon::parse($bill->bill_date)->format('d-M-y') : 'N/A' }}</td>
                        <td class="fw-bold" style="font-size:.85rem">£{{ number_format($bill->total_amount,2) }}</td>
                        <td>
                            @if($bill->status=='Paid') <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Paid</span>
                            @elseif($bill->status=='Unpaid') <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Unpaid</span>
                            @else <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">{{ $bill->status }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{-- View button → opens Bill Detail Modal --}}
                            <button class="btn btn-sm btn-light text-primary me-1"
                                data-bs-toggle="modal" data-bs-target="#viewBillModal"
                                data-bill="{{ $bill->bill_no }}"
                                data-patient="{{ $bname }}"
                                data-date="{{ $bill->bill_date ? \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') : 'N/A' }}"
                                data-amount="£{{ number_format($bill->total_amount,2) }}"
                                data-status="{{ $bill->status }}"
                                title="View"><i class="bi bi-eye"></i></button>
                            {{-- Pay button → opens Pay Confirm Modal --}}
                            @if($bill->status=='Unpaid')
                            <button class="btn btn-sm btn-light text-success"
                                data-bs-toggle="modal" data-bs-target="#payBillModal"
                                data-action="{{ route('billing.pay', $bill->bill_no) }}"
                                data-patient="{{ $bname }}"
                                data-amount="£{{ number_format($bill->total_amount,2) }}"
                                title="Record Payment"><i class="bi bi-cash-stack"></i></button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No bills found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($bills->hasPages())
        <div class="card-footer bg-white border-0 py-3 px-4">{{ $bills->appends(request()->except('bills_page'))->links() }}</div>
        @endif
    </div>
</div>

{{-- ── REQUISITION TAB ──────────────────────────────────────── --}}
<div class="tab-pane fade" id="requisitionTab">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('requisitions.create') }}" class="btn btn-primary px-4"><i class="bi bi-plus-circle me-2"></i>New Requisition</a>
    </div>
    <div class="card border-0 rounded-4 overflow-hidden mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead><tr>
                        <th>Req No</th><th>Ward</th><th>Requested By</th><th>Date</th><th>Items</th><th>Status</th><th class="text-center">Action</th>
                    </tr></thead>
                    <tbody>
                    @forelse($requisitions as $req)
                    <tr>
                        <td class="fw-medium px-4">{{ $req->requisition_no }}</td>
                        <td style="font-size:.85rem">{{ $req->ward ? $req->ward->ward_name : '—' }}</td>
                        <td style="font-size:.85rem">{{ $req->staff ? $req->staff->first_name.' '.$req->staff->last_name : '—' }}</td>
                        <td style="font-size:.85rem">{{ $req->date_ordered ? \Carbon\Carbon::parse($req->date_ordered)->format('d-M-y') : 'N/A' }}</td>
                        <td><span class="badge bg-secondary rounded-pill">{{ $req->items->count() }} items</span></td>
                        <td>
                            @if($req->status=='Pending') <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Pending</span>
                            @elseif($req->status=='Approved') <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Approved</span>
                            @elseif($req->status=='Delivered') <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">Delivered</span>
                            @else <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">{{ $req->status }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{-- View --}}
                            <button class="btn btn-sm btn-light text-primary me-1"
                                data-bs-toggle="modal" data-bs-target="#viewReqModal"
                                data-req="{{ $req->requisition_no }}"
                                data-ward="{{ $req->ward ? $req->ward->ward_name : '—' }}"
                                data-staff="{{ $req->staff ? $req->staff->first_name.' '.$req->staff->last_name : '—' }}"
                                data-date="{{ $req->date_ordered ? \Carbon\Carbon::parse($req->date_ordered)->format('d M Y') : 'N/A' }}"
                                data-status="{{ $req->status }}"
                                data-items="{{ $req->items->count() }}"
                                title="View"><i class="bi bi-eye"></i></button>
                            {{-- Approve --}}
                            @if($req->status=='Pending')
                            <button class="btn btn-sm btn-light text-success"
                                data-bs-toggle="modal" data-bs-target="#approveReqModal"
                                data-action="{{ route('requisitions.approve', $req->requisition_no) }}"
                                data-req="{{ $req->requisition_no }}"
                                data-ward="{{ $req->ward ? $req->ward->ward_name : '—' }}"
                                title="Approve"><i class="bi bi-check-lg"></i></button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No requisitions found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($requisitions->hasPages())
        <div class="card-footer bg-white border-0 py-3 px-4">{{ $requisitions->appends(request()->except('req_page'))->links() }}</div>
        @endif
    </div>
</div>

{{-- ── SUPPLIERS & STOCK TAB ────────────────────────────────── --}}
<div class="tab-pane fade" id="supplierTab">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 rounded-4 overflow-hidden mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Stock Levels</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addItemModal"><i class="bi bi-plus-circle me-1"></i>Add Item</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead><tr><th>Item</th><th>In Stock</th><th>Reorder Level</th><th>Cost/Unit</th><th>Status</th></tr></thead>
                            <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td class="fw-medium px-4">{{ $item->name }}</td>
                                <td style="font-size:.85rem">{{ $item->quantity_in_stock }}</td>
                                <td style="font-size:.85rem">{{ $item->reorder_level }}</td>
                                <td style="font-size:.85rem">£{{ number_format($item->cost_per_unit,2) }}</td>
                                <td>
                                    @if($item->quantity_in_stock <= $item->reorder_level)
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Low Stock</span>
                                    @else
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($items->hasPages())
                <div class="card-footer bg-white border-0 py-3 px-4">{{ $items->appends(request()->except('items_page'))->links() }}</div>
                @endif
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 rounded-4 mb-4">
                <div class="card-header border-bottom"><h5 class="mb-0 fw-bold">Suppliers</h5></div>
                <div class="card-body p-0" style="max-height:500px;overflow-y:auto;">
                    @forelse($suppliers as $supplier)
                    <div class="px-3 py-3" style="border-bottom:1px solid var(--border);">
                        <div class="fw-bold" style="font-size:.85rem">{{ $supplier->name }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ Str::limit($supplier->address,30) }} · {{ $supplier->telephone_number }}</div>
                    </div>
                    @empty
                    <div class="px-3 py-4 text-center text-muted">No suppliers found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

</div>{{-- end tab-content --}}
</div>{{-- end container --}}

{{-- ══ MODALS ══════════════════════════════════════════════════ --}}

{{-- View Bill Modal --}}
<div class="modal fade" id="viewBillModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-receipt me-2 text-primary"></i>Bill Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <div class="row g-3">
                    <div class="col-6"><div class="text-muted small">Bill No</div><div class="fw-bold" id="vb-bill_no">—</div></div>
                    <div class="col-6"><div class="text-muted small">Status</div><div id="vb-status">—</div></div>
                    <div class="col-12"><div class="text-muted small">Patient</div><div class="fw-bold" id="vb-patient">—</div></div>
                    <div class="col-6"><div class="text-muted small">Date</div><div id="vb-date">—</div></div>
                    <div class="col-6"><div class="text-muted small">Total Amount</div><div class="fw-bold fs-5 text-primary" id="vb-amount">—</div></div>
                </div>
            </div>
            <div class="modal-footer border-0"><button class="btn btn-light px-4" data-bs-dismiss="modal">Close</button></div>
        </div>
    </div>
</div>

{{-- Pay Bill Confirm Modal --}}
<div class="modal fade" id="payBillModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-cash-stack me-2 text-success"></i>Record Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">You are about to mark this bill as <strong>Paid</strong> and record a cash payment.</p>
                <div class="bg-light rounded-3 p-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Patient</span><span class="fw-bold" id="pay-patient">—</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Amount Due</span><span class="fw-bold text-success fs-5" id="pay-amount">—</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                <form id="payBillForm" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success px-4"><i class="bi bi-check-circle me-2"></i>Confirm Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- View Requisition Modal --}}
<div class="modal fade" id="viewReqModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-box-seam me-2 text-primary"></i>Requisition Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <div class="row g-3">
                    <div class="col-6"><div class="text-muted small">Req No</div><div class="fw-bold" id="vr-req">—</div></div>
                    <div class="col-6"><div class="text-muted small">Status</div><div id="vr-status">—</div></div>
                    <div class="col-12"><div class="text-muted small">Ward</div><div class="fw-bold" id="vr-ward">—</div></div>
                    <div class="col-12"><div class="text-muted small">Requested By</div><div id="vr-staff">—</div></div>
                    <div class="col-6"><div class="text-muted small">Date Ordered</div><div id="vr-date">—</div></div>
                    <div class="col-6"><div class="text-muted small">Items</div><div id="vr-items">—</div></div>
                </div>
            </div>
            <div class="modal-footer border-0"><button class="btn btn-light px-4" data-bs-dismiss="modal">Close</button></div>
        </div>
    </div>
</div>

{{-- Approve Requisition Confirm Modal --}}
<div class="modal fade" id="approveReqModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-check-circle me-2 text-success"></i>Approve Requisition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Are you sure you want to approve this ward requisition?</p>
                <div class="bg-light rounded-3 p-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Requisition No</span><span class="fw-bold" id="apr-req">—</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Destination Ward</span><span class="fw-bold" id="apr-ward">—</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                <form id="approveReqForm" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success px-4"><i class="bi bi-check-circle me-2"></i>Approve</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Add Item Modal --}}
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2 text-primary"></i>Add Inventory Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('items.store') }}" method="POST">
                @csrf
                <div class="modal-body pt-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">Item Code <span class="text-danger">*</span></label>
                            <input type="text" name="item_no" class="form-control" placeholder="e.g. ITEM011" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-medium small">Item Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Sterile Wipes" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium small">Description</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Optional description..."></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">Qty In Stock <span class="text-danger">*</span></label>
                            <input type="number" name="quantity_in_stock" class="form-control" min="0" value="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">Reorder Level <span class="text-danger">*</span></label>
                            <input type="number" name="reorder_level" class="form-control" min="0" value="10" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">Cost per Unit (£) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="cost_per_unit" class="form-control" min="0" placeholder="0.00" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium small">Supplier</label>
                            <select name="supplier_no" class="form-select">
                                <option value="">— No Supplier —</option>
                                @foreach($suppliers as $sup)
                                    <option value="{{ $sup->supplier_no }}">{{ $sup->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Add Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══ MODAL JAVASCRIPT ═══════════════════════════════════════ --}}
<script>
// View Bill Modal
document.getElementById('viewBillModal').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('vb-bill_no').textContent = btn.dataset.bill;
    document.getElementById('vb-patient').textContent = btn.dataset.patient;
    document.getElementById('vb-date').textContent = btn.dataset.date;
    document.getElementById('vb-amount').textContent = btn.dataset.amount;
    const st = btn.dataset.status;
    document.getElementById('vb-status').innerHTML =
        st === 'Paid'
            ? '<span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Paid</span>'
            : '<span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Unpaid</span>';
});

// Pay Bill Modal
document.getElementById('payBillModal').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('pay-patient').textContent = btn.dataset.patient;
    document.getElementById('pay-amount').textContent = btn.dataset.amount;
    document.getElementById('payBillForm').action = btn.dataset.action;
});

// View Requisition Modal
document.getElementById('viewReqModal').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('vr-req').textContent = btn.dataset.req;
    document.getElementById('vr-ward').textContent = btn.dataset.ward;
    document.getElementById('vr-staff').textContent = btn.dataset.staff;
    document.getElementById('vr-date').textContent = btn.dataset.date;
    document.getElementById('vr-items').textContent = btn.dataset.items + ' item(s)';
    const st = btn.dataset.status;
    const colors = {Pending:'warning',Approved:'success',Delivered:'info'};
    const c = colors[st] || 'secondary';
    document.getElementById('vr-status').innerHTML = `<span class="badge bg-${c} bg-opacity-10 text-${c} rounded-pill px-3">${st}</span>`;
});

// Approve Requisition Modal
document.getElementById('approveReqModal').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('apr-req').textContent = btn.dataset.req;
    document.getElementById('apr-ward').textContent = btn.dataset.ward;
    document.getElementById('approveReqForm').action = btn.dataset.action;
});
</script>
@endsection
