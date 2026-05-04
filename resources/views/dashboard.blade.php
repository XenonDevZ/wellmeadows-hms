@extends('layouts.app')

@section('title', 'Dashboard — WellMeadows HMS')
@section('page_title', 'Dashboard')

@section('content')
<!-- Welcome banner -->
<div class="mb-4">
    <h3 class="fw-bold mb-1" style="letter-spacing:-0.5px;">Good morning, Admin 👋</h3>
    <p class="text-muted mb-0" style="font-size:0.9rem;">Here's an overview of WellMeadows Hospital today.</p>
</div>

<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-between align-items-center rounded-4">
            <div>
                <p class="fs-6 text-muted mb-1" style="font-size:0.78rem!important;">Total Patients</p>
                <h3 class="fs-2 fw-bold mb-0">{{ number_format($totalPatients) }}</h3>
                <small style="font-size:0.7rem;color:#10B981;font-weight:600;">
                    <i class="bi bi-arrow-up-short"></i>+12 this week
                </small>
            </div>
            <div style="width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:rgba(99,102,241,0.1);">
                <i class="bi bi-people-fill" style="font-size:1.3rem;color:#6366F1;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-between align-items-center rounded-4">
            <div>
                <p class="fs-6 text-muted mb-1" style="font-size:0.78rem!important;">Available Beds</p>
                <h3 class="fs-2 fw-bold mb-0">{{ number_format($availableBeds) }}</h3>
                <small style="font-size:0.7rem;color:#F59E0B;font-weight:600;">
                    <i class="bi bi-dash"></i>Active
                </small>
            </div>
            <div style="width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:rgba(16,185,129,0.1);">
                <i class="bi bi-hospital" style="font-size:1.3rem;color:#10B981;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-between align-items-center rounded-4">
            <div>
                <p class="fs-6 text-muted mb-1" style="font-size:0.78rem!important;">Today's Appointments</p>
                <h3 class="fs-2 fw-bold mb-0">{{ number_format($upcomingAppointments) }}</h3>
                <small style="font-size:0.7rem;color:#6366F1;font-weight:600;">
                    <i class="bi bi-clock"></i> Upcoming
                </small>
            </div>
            <div style="width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:rgba(245,158,11,0.1);">
                <i class="bi bi-calendar-check" style="font-size:1.3rem;color:#F59E0B;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-between align-items-center rounded-4">
            <div>
                <p class="fs-6 text-muted mb-1" style="font-size:0.78rem!important;">Low Stock Items</p>
                <h3 class="fs-2 fw-bold mb-0">{{ number_format($lowStockItems) }}</h3>
                <small style="font-size:0.7rem;color:#EF4444;font-weight:600;">
                    <i class="bi bi-exclamation-triangle"></i> Action needed
                </small>
            </div>
            <div style="width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:rgba(239,68,68,0.1);">
                <i class="bi bi-box-seam" style="font-size:1.3rem;color:#EF4444;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="d-flex gap-2 mb-4">
    <a href="/patients/create" class="btn btn-primary px-4"><i class="bi bi-person-plus me-2"></i>Register Patient</a>
    <a href="/appointments/create" class="btn btn-outline-secondary"><i class="bi bi-calendar-plus me-2"></i>New Appointment</a>
    <a href="/wards" class="btn btn-outline-secondary"><i class="bi bi-building me-2"></i>View Wards</a>
</div>

<div class="row g-4">
    <!-- Recent Admissions -->
    <div class="col-lg-8">
        <div class="card border-0 rounded-4 overflow-hidden">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Recent Admissions</h5>
                <a href="/wards" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Patient</th>
                            <th>Ward</th>
                            <th>Bed</th>
                            <th>Date Admitted</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAdmissions as $admission)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($admission->patient->first_name . ' ' . $admission->patient->last_name) }}&background=6366F1&color=fff&size=32" class="rounded-circle" width="32" height="32">
                                    <div>
                                        <div class="fw-bold" style="font-size:0.85rem;">{{ $admission->patient->first_name }} {{ $admission->patient->last_name }}</div>
                                        <div class="text-muted" style="font-size:0.72rem;">{{ $admission->patient_no }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:0.85rem;">{{ $admission->ward->ward_name }} ({{ $admission->ward_no }})</td>
                            <td>
                                @if($admission->bed_no)
                                    <span class="badge bg-secondary">{{ $admission->bed_no }}</span>
                                @else
                                    <span class="text-muted" style="font-size:0.75rem;">—</span>
                                @endif
                            </td>
                            <td style="font-size:0.85rem;">{{ \Carbon\Carbon::parse($admission->date_placed_in_ward)->format('d-M-y') }}</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Admitted</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No recent admissions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Sidebar: Activity & Quick Stats -->
    <div class="col-lg-4">
        <!-- Ward Occupancy -->
        <div class="card border-0 rounded-4 mb-3">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">Ward Occupancy</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:0.82rem;font-weight:600;">Ward 11 — Orthopaedic</span>
                        <span style="font-size:0.75rem;font-weight:600;color:var(--text-muted);">80%</span>
                    </div>
                    <div class="progress" style="height:6px;">
                        <div class="progress-bar" role="progressbar" style="width:80%;background:var(--accent);border-radius:100px;"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:0.82rem;font-weight:600;">Ward 12 — Pediatrics</span>
                        <span style="font-size:0.75rem;font-weight:600;color:var(--text-muted);">87%</span>
                    </div>
                    <div class="progress" style="height:6px;">
                        <div class="progress-bar" role="progressbar" style="width:87%;background:#F59E0B;border-radius:100px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card border-0 rounded-4">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">Recent Activity</h5>
            </div>
            <div class="card-body p-0">
                <div class="px-3 py-2" style="border-bottom:1px solid var(--border);">
                    <div class="d-flex gap-2 align-items-start">
                        <div style="width:6px;height:6px;border-radius:50%;background:#10B981;margin-top:7px;flex-shrink:0;"></div>
                        <div>
                            <div style="font-size:0.8rem;font-weight:500;">Patient <strong>Robert Drumtree</strong> admitted to Ward 11</div>
                            <div style="font-size:0.68rem;color:var(--text-muted);">2 hours ago</div>
                        </div>
                    </div>
                </div>
                <div class="px-3 py-2" style="border-bottom:1px solid var(--border);">
                    <div class="d-flex gap-2 align-items-start">
                        <div style="width:6px;height:6px;border-radius:50%;background:#6366F1;margin-top:7px;flex-shrink:0;"></div>
                        <div>
                            <div style="font-size:0.8rem;font-weight:500;">Appointment <strong>#A001</strong> scheduled for Anne Phelps</div>
                            <div style="font-size:0.68rem;color:var(--text-muted);">5 hours ago</div>
                        </div>
                    </div>
                </div>
                <div class="px-3 py-2">
                    <div class="d-flex gap-2 align-items-start">
                        <div style="width:6px;height:6px;border-radius:50%;background:#EF4444;margin-top:7px;flex-shrink:0;"></div>
                        <div>
                            <div style="font-size:0.8rem;font-weight:500;"><strong>Bandages</strong> stock below reorder level</div>
                            <div style="font-size:0.68rem;color:var(--text-muted);">1 day ago</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
