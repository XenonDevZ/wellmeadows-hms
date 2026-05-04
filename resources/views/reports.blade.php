@extends('layouts.app')

@section('title', 'Reports — WellMeadows HMS')
@section('page_title', 'Hospital Reports & Case Studies')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1" style="letter-spacing:-0.5px;">Analytics & Reports</h3>
    <p class="text-muted mb-0" style="font-size:0.9rem;">Generate and view official hospital reports and case studies.</p>
</div>

<div class="row g-4">
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body p-4 text-center">
                <div style="width:64px;height:64px;border-radius:16px;background:rgba(99,102,241,0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                    <i class="bi bi-file-earmark-person" style="font-size:2rem;color:#6366F1;"></i>
                </div>
                <h5 class="fw-bold mb-2">Ward Allocation Report</h5>
                <p class="text-muted small mb-4">View comprehensive details of patients allocated to wards, including charge nurse information.</p>
                <button class="btn btn-primary w-100"><i class="bi bi-printer me-2"></i>Generate Report</button>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body p-4 text-center">
                <div style="width:64px;height:64px;border-radius:16px;background:rgba(16,185,129,0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                    <i class="bi bi-file-earmark-medical" style="font-size:2rem;color:#10B981;"></i>
                </div>
                <h5 class="fw-bold mb-2">Medication Report</h5>
                <p class="text-muted small mb-4">A detailed breakdown of patient medications prescribed per ward and doctor.</p>
                <button class="btn btn-outline-success w-100"><i class="bi bi-printer me-2"></i>Generate Report</button>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body p-4 text-center">
                <div style="width:64px;height:64px;border-radius:16px;background:rgba(245,158,11,0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                    <i class="bi bi-clipboard2-data" style="font-size:2rem;color:#F59E0B;"></i>
                </div>
                <h5 class="fw-bold mb-2">Ward Requisitions</h5>
                <p class="text-muted small mb-4">Weekly requisition reports for medical and surgical supplies ordered by charge nurses.</p>
                <button class="btn btn-outline-warning w-100"><i class="bi bi-printer me-2"></i>Generate Report</button>
            </div>
        </div>
    </div>
</div>
@endsection
