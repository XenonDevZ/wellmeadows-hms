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
                            <div class="input-group shadow-sm rounded" style="max-width:280px;">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" id="billSearch" class="form-control border-start-0 ps-0" placeholder="Search bills...">
                            </div>
                        </div>

                        <div class="card border-0 rounded-4 overflow-hidden">
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
                                        <tr>
                                            <td class="fw-medium text-dark px-4">B001</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="https://ui-avatars.com/api/?name=Robert+Drumtree&background=6366F1&color=fff&size=32" class="rounded-circle" width="32" height="32">
                                                    <div>
                                                        <div class="fw-bold" style="font-size:0.85rem;">Robert Drumtree</div>
                                                        <div class="text-muted" style="font-size:0.72rem;">P10451</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="font-size:0.85rem;">20-Jan-96</td>
                                            <td class="fw-bold" style="font-size:0.85rem;">£1,250.00</td>
                                            <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Unpaid</span></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-light text-primary me-1" title="View"><i class="bi bi-eye"></i></button>
                                                <button class="btn btn-sm btn-light text-success" title="Record Payment"><i class="bi bi-cash-stack"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium text-dark px-4">B002</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="https://ui-avatars.com/api/?name=Anne+Phelps&background=10B981&color=fff&size=32" class="rounded-circle" width="32" height="32">
                                                    <div>
                                                        <div class="fw-bold" style="font-size:0.85rem;">Anne Phelps</div>
                                                        <div class="text-muted" style="font-size:0.72rem;">P10234</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="font-size:0.85rem;">18-Jan-96</td>
                                            <td class="fw-bold" style="font-size:0.85rem;">£350.00</td>
                                            <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Paid</span></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-light text-primary me-1" title="View"><i class="bi bi-eye"></i></button>
                                                <button class="btn btn-sm btn-light text-secondary" title="Print"><i class="bi bi-printer"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- ── Requisition Tab ─────────────────────────────────── -->
                    <div class="tab-pane fade" id="requisitionTab">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <button class="btn btn-primary px-4"><i class="bi bi-plus-circle me-2"></i>New Requisition</button>
                        </div>

                        <div class="card border-0 rounded-4 overflow-hidden">
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
                                        <tr>
                                            <td class="fw-medium text-dark px-4">R001</td>
                                            <td style="font-size:0.85rem;">Ward 11 — Orthopaedic</td>
                                            <td style="font-size:0.85rem;">Moira Samuel (S10124)</td>
                                            <td style="font-size:0.85rem;">10-Jan-96</td>
                                            <td><span class="badge bg-secondary rounded-pill">3 items</span></td>
                                            <td><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Pending</span></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-light text-primary me-1" title="View"><i class="bi bi-eye"></i></button>
                                                <button class="btn btn-sm btn-light text-success" title="Approve"><i class="bi bi-check-lg"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- ── Suppliers & Stock Tab ───────────────────────────── -->
                    <div class="tab-pane fade" id="supplierTab">
                        <div class="row g-4">
                            <!-- Low Stock Alerts -->
                            <div class="col-lg-8">
                                <div class="card border-0 rounded-4 overflow-hidden">
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
                                                <tr>
                                                    <td class="fw-medium text-dark px-4">Bandages (Large)</td>
                                                    <td style="font-size:0.85rem;">15</td>
                                                    <td style="font-size:0.85rem;">25</td>
                                                    <td style="font-size:0.85rem;">£2.50</td>
                                                    <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Low Stock</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium text-dark px-4">Surgical Gloves (M)</td>
                                                    <td style="font-size:0.85rem;">200</td>
                                                    <td style="font-size:0.85rem;">50</td>
                                                    <td style="font-size:0.85rem;">£0.15</td>
                                                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">In Stock</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium text-dark px-4">Paracetamol 500mg</td>
                                                    <td style="font-size:0.85rem;">8</td>
                                                    <td style="font-size:0.85rem;">20</td>
                                                    <td style="font-size:0.85rem;">£0.05</td>
                                                    <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Low Stock</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Suppliers List -->
                            <div class="col-lg-4">
                                <div class="card border-0 rounded-4">
                                    <div class="card-header">
                                        <h5 class="mb-0 fw-bold">Suppliers</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="px-3 py-3" style="border-bottom:1px solid var(--border);">
                                            <div class="fw-bold" style="font-size:0.85rem;">MediSupply Ltd</div>
                                            <div class="text-muted" style="font-size:0.75rem;">Edinburgh · 0131-222-3333</div>
                                        </div>
                                        <div class="px-3 py-3" style="border-bottom:1px solid var(--border);">
                                            <div class="fw-bold" style="font-size:0.85rem;">PharmaCo UK</div>
                                            <div class="text-muted" style="font-size:0.75rem;">Glasgow · 0141-444-5555</div>
                                        </div>
                                        <div class="px-3 py-3">
                                            <div class="fw-bold" style="font-size:0.85rem;">Hospital Essentials</div>
                                            <div class="text-muted" style="font-size:0.75rem;">London · 0207-111-2222</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            
</div>
@endsection
