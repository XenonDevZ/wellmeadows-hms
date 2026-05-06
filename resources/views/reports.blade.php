@extends('layouts.app')
@section('title', 'Reports — WellMeadows HMS')
@section('page_title', 'Hospital Reports')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1" style="letter-spacing:-0.5px;">Analytics & Reports</h3>
    <p class="text-muted mb-0" style="font-size:.9rem">Generate and print official hospital reports and case studies.</p>
</div>

<div class="row g-4">

    {{-- Ward Allocation --}}
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:52px;height:52px;border-radius:14px;background:rgba(99,102,241,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi bi-hospital" style="font-size:1.6rem;color:#6366F1"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Ward Allocation</h5>
                        <span class="badge rounded-pill" style="background:rgba(99,102,241,.12);color:#6366F1;font-size:.75rem">{{ $stats['ward_patients'] }} active patients</span>
                    </div>
                </div>
                <p class="text-muted small mb-4 flex-grow-1">Patients allocated to wards, bed assignments, charge nurse, and expected discharge dates.</p>
                <a href="{{ route('reports.ward_allocation') }}" class="btn btn-primary w-100"><i class="bi bi-printer me-2"></i>Generate Report</a>
            </div>
        </div>
    </div>

    {{-- Patient Billing --}}
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:52px;height:52px;border-radius:14px;background:rgba(16,185,129,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi bi-receipt-cutoff" style="font-size:1.6rem;color:#10B981"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Patient Billing</h5>
                        <span class="badge rounded-pill" style="background:rgba(16,185,129,.12);color:#10B981;font-size:.75rem">{{ $stats['bills'] }} bills</span>
                    </div>
                </div>
                <p class="text-muted small mb-4 flex-grow-1">Financial summary of all patient bills, paid vs. outstanding, and revenue totals.</p>
                <a href="{{ route('reports.billing') }}" class="btn btn-success w-100"><i class="bi bi-printer me-2"></i>Generate Report</a>
            </div>
        </div>
    </div>

    {{-- Appointments --}}
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:52px;height:52px;border-radius:14px;background:rgba(245,158,11,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi bi-calendar2-check" style="font-size:1.6rem;color:#F59E0B"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Appointments</h5>
                        <span class="badge rounded-pill" style="background:rgba(245,158,11,.12);color:#F59E0B;font-size:.75rem">{{ $stats['appointments'] }} total</span>
                    </div>
                </div>
                <p class="text-muted small mb-4 flex-grow-1">Full appointment schedule with patient, doctor, date, time, and status breakdown.</p>
                <a href="{{ route('reports.appointments') }}" class="btn btn-warning w-100"><i class="bi bi-printer me-2"></i>Generate Report</a>
            </div>
        </div>
    </div>

    {{-- Ward Requisitions --}}
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:52px;height:52px;border-radius:14px;background:rgba(236,72,153,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi bi-clipboard2-data" style="font-size:1.6rem;color:#EC4899"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Ward Requisitions</h5>
                        <span class="badge rounded-pill" style="background:rgba(236,72,153,.12);color:#EC4899;font-size:.75rem">{{ $stats['requisitions'] }} orders</span>
                    </div>
                </div>
                <p class="text-muted small mb-4 flex-grow-1">Supply requisitions per ward, items ordered, approval status, and responsible staff.</p>
                <a href="{{ route('reports.requisitions') }}" class="btn w-100" style="background:#EC4899;color:#fff"><i class="bi bi-printer me-2"></i>Generate Report</a>
            </div>
        </div>
    </div>

    {{-- Medications --}}
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:52px;height:52px;border-radius:14px;background:rgba(139,92,246,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi bi-capsule" style="font-size:1.6rem;color:#8B5CF6"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Medications</h5>
                        <span class="badge rounded-pill" style="background:rgba(139,92,246,.12);color:#8B5CF6;font-size:.75rem">{{ $stats['medications'] }} prescriptions</span>
                    </div>
                </div>
                <p class="text-muted small mb-4 flex-grow-1">Patient prescriptions, dosage, frequency, and duration assigned by clinical staff.</p>
                <a href="{{ route('reports.medications') }}" class="btn w-100" style="background:#8B5CF6;color:#fff"><i class="bi bi-printer me-2"></i>Generate Report</a>
            </div>
        </div>
    </div>

</div>
@endsection
