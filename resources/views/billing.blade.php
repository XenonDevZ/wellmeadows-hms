@extends("layouts.app")

@section("title", "Billing & Requisition — WellMeadows HMS")
@section("page_title", "Billing & Requisition")

@section("content")
<div class="container-fluid px-0">


                <!-- Tabs: Billing | Requisitions -->
                <ul class="nav nav-tabs mb-4 border-0" id="billingTabs">
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#billingTab" style="border-radius:8px 8px 0 0;">
                            <i class="bi bi-receipt me-2"></i>Patient Billing
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#requisitionTab" style="border-radius:8px 8px 0 0;">
                            <i class="bi bi-box-seam me-2"></i>Ward Requisitions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#supplierTab" style="border-radius:8px 8px 0 0;">
                            <i class="bi bi-truck me-2"></i>Suppliers & Stock
                        </a>
                    </li>
                </ul>

                <div class="tab-content">

                    <!-- ── Billing Tab ─────────────────────────────────────── -->
                    <div class="tab-pane fade show active" id="billingTab">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <button class="btn btn-primary px-4"><i class="bi bi-plus-circle me-2"></i>Create Bill</button>
                            <form method="GET" action="{{ route('billing.index') }}" class="m-0">
                                <div class="input-group shadow-sm rounded" style="max-width:280px;">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                                    <input type="text" name="bill_search" value="{{ request('bill_search') }}" class="form-control border-start-0 ps-0" placeholder="Search bills...">
                                </div>
                            </form>
                        </div>

                        <div class="card border-0 rounded-4 overflow-hidden mb-4">
                            <div class="card-body p-0">
                                <table class="table table-hover mb-0 align-middle" id="billTable">
                                    <thead>
                                        <tr>
                                            <th>Bill No</th>
                                            <th>Patient</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($bills as $bill)
                                        <tr>
                                            <td class="fw-medium text-dark px-4">{{ $bill->bill_no }}</td>
                                            <td>
                                                @if($bill->patient)
                                                    <div class="d-flex align-items-center gap-2">
                                                        @php
                                                            $fullName = $bill->patient->first_name . ' ' . $bill->patient->last_name;
                                                            $colors = ['6366F1', '10B981', 'F59E0B', 'EC4899', '8B5CF6'];
                                                            $color = $colors[crc32($bill->patient->patient_no) % count($colors)];
                                                        @endphp
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($fullName) }}&background={{ $color }}&color=fff&size=32" class="rounded-circle" width="32" height="32">
                                                        <div>
                                                            <div class="fw-bold" style="font-size:0.85rem;">{{ $fullName }}</div>
                                                            <div class="text-muted" style="font-size:0.72rem;">{{ $bill->patient_no }}</div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Unknown Patient</span>
                                                @endif
                                            </td>
                                            <td style="font-size:0.85rem;">{{ $bill->bill_date ? \Carbon\Carbon::parse($bill->bill_date)->format('d-M-y') : 'N/A' }}</td>
                                            <td class="fw-bold" style="font-size:0.85rem;">£{{ number_format($bill->total_amount, 2) }}</td>
                                            <td>
                                                @if($bill->status == 'Paid')
                                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Paid</span>
                                                @elseif($bill->status == 'Unpaid')
                                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Unpaid</span>
                                                @else
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">{{ $bill->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-light text-primary me-1" title="View"><i class="bi bi-eye"></i></button>
                                                <button class="btn btn-sm btn-light text-success" title="Record Payment"><i class="bi bi-cash-stack"></i></button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">No bills found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($bills->hasPages())
                            <div class="card-footer bg-white border-0 py-3 px-4">
                                {{ $bills->appends(request()->except('bills_page'))->links() }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- ── Requisition Tab ─────────────────────────────────── -->
                    <div class="tab-pane fade" id="requisitionTab">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <button class="btn btn-primary px-4"><i class="bi bi-plus-circle me-2"></i>New Requisition</button>
                        </div>

                        <div class="card border-0 rounded-4 overflow-hidden mb-4">
                            <div class="card-body p-0">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead>
                                        <tr>
                                            <th>Req No</th>
                                            <th>Ward</th>
                                            <th>Requested By</th>
                                            <th>Date Ordered</th>
                                            <th>Items</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($requisitions as $req)
                                        <tr>
                                            <td class="fw-medium text-dark px-4">{{ $req->requisition_no }}</td>
                                            <td style="font-size:0.85rem;">{{ $req->ward ? $req->ward->ward_name : 'Unknown Ward' }}</td>
                                            <td style="font-size:0.85rem;">
                                                @if($req->staff)
                                                    {{ $req->staff->first_name }} {{ $req->staff->last_name }} ({{ $req->staff_no }})
                                                @else
                                                    Unknown
                                                @endif
                                            </td>
                                            <td style="font-size:0.85rem;">{{ $req->date_ordered ? \Carbon\Carbon::parse($req->date_ordered)->format('d-M-y') : 'N/A' }}</td>
                                            <td><span class="badge bg-secondary rounded-pill">{{ $req->items->count() }} items</span></td>
                                            <td>
                                                @if($req->status == 'Pending')
                                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Pending</span>
                                                @elseif($req->status == 'Approved')
                                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Approved</span>
                                                @elseif($req->status == 'Delivered')
                                                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">Delivered</span>
                                                @else
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">{{ $req->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-light text-primary me-1" title="View"><i class="bi bi-eye"></i></button>
                                                <button class="btn btn-sm btn-light text-success" title="Approve"><i class="bi bi-check-lg"></i></button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">No requisitions found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($requisitions->hasPages())
                            <div class="card-footer bg-white border-0 py-3 px-4">
                                {{ $requisitions->appends(request()->except('req_page'))->links() }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- ── Suppliers & Stock Tab ───────────────────────────── -->
                    <div class="tab-pane fade" id="supplierTab">
                        <div class="row g-4">
                            <!-- Low Stock Alerts -->
                            <div class="col-lg-8">
                                <div class="card border-0 rounded-4 overflow-hidden mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 fw-bold">Stock Levels</h5>
                                        <button class="btn btn-sm btn-outline-primary">Add Item</button>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-hover mb-0 align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>In Stock</th>
                                                    <th>Reorder Level</th>
                                                    <th>Cost/Unit</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($items as $item)
                                                <tr>
                                                    <td class="fw-medium text-dark px-4">{{ $item->item_name }}</td>
                                                    <td style="font-size:0.85rem;">{{ $item->quantity_in_stock }}</td>
                                                    <td style="font-size:0.85rem;">{{ $item->reorder_level }}</td>
                                                    <td style="font-size:0.85rem;">£{{ number_format($item->cost_per_unit, 2) }}</td>
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
                                    @if($items->hasPages())
                                    <div class="card-footer bg-white border-0 py-3 px-4">
                                        {{ $items->appends(request()->except('items_page'))->links() }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Suppliers List -->
                            <div class="col-lg-4">
                                <div class="card border-0 rounded-4 mb-4">
                                    <div class="card-header border-bottom">
                                        <h5 class="mb-0 fw-bold">Suppliers</h5>
                                    </div>
                                    <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                                        @forelse($suppliers as $supplier)
                                        <div class="px-3 py-3" style="border-bottom:1px solid var(--border);">
                                            <div class="fw-bold" style="font-size:0.85rem;">{{ $supplier->name }}</div>
                                            <div class="text-muted" style="font-size:0.75rem;">{{ Str::limit($supplier->address, 30) }} · {{ $supplier->telephone_number }}</div>
                                        </div>
                                        @empty
                                        <div class="px-3 py-4 text-center text-muted">No suppliers found.</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            
</div>
@endsection
