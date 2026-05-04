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
                                <h3 class="fs-2 fw-bold mb-0">18</h3>
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
                                <h3 class="fs-2 fw-bold mb-0">12</h3>
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
                                <h3 class="fs-2 fw-bold mb-0">4</h3>
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
                                <h3 class="fs-2 fw-bold mb-0">2</h3>
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
                        <button class="btn btn-primary px-4"><i class="bi bi-calendar-plus me-2"></i>New Appointment</button>
                        <button class="btn btn-outline-secondary"><i class="bi bi-prescription2 me-2"></i>Treatments</button>
                    </div>
                    <div class="input-group shadow-sm rounded" style="max-width:280px;">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="appointmentSearch" class="form-control border-start-0 ps-0" placeholder="Search appointments...">
                    </div>
                </div>

                <!-- Appointments Table -->
                <div class="card border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0 align-middle" id="appointmentTable">
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
                                <tr>
                                    <td class="fw-medium text-dark px-4">A001</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Anne+Phelps&background=6366F1&color=fff&size=32" class="rounded-circle" width="32" height="32">
                                            <div>
                                                <div class="fw-bold" style="font-size:0.85rem;">Anne Phelps</div>
                                                <div class="text-muted" style="font-size:0.72rem;">P10234</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="font-size:0.85rem;">14-Jan-96</td>
                                    <td style="font-size:0.85rem;">10:00</td>
                                    <td><span class="badge bg-secondary rounded-pill">Room 3</span></td>
                                    <td style="font-size:0.85rem;">Dr. McCrae</td>
                                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Completed</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-light text-primary me-1" title="View"><i class="bi bi-eye"></i></button>
                                        <button class="btn btn-sm btn-light text-warning" title="Edit"><i class="bi bi-pencil"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium text-dark px-4">A002</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Robert+Drumtree&background=10B981&color=fff&size=32" class="rounded-circle" width="32" height="32">
                                            <div>
                                                <div class="fw-bold" style="font-size:0.85rem;">Robert Drumtree</div>
                                                <div class="text-muted" style="font-size:0.72rem;">P10451</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="font-size:0.85rem;">15-Jan-96</td>
                                    <td style="font-size:0.85rem;">14:30</td>
                                    <td><span class="badge bg-secondary rounded-pill">Room 1</span></td>
                                    <td style="font-size:0.85rem;">Dr. McCrae</td>
                                    <td><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Scheduled</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-light text-primary me-1" title="View"><i class="bi bi-eye"></i></button>
                                        <button class="btn btn-sm btn-light text-warning" title="Edit"><i class="bi bi-pencil"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                        <small class="text-muted">Showing 1–2 of 2 appointments</small>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

            
</div>
@endsection
