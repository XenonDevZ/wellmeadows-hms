@extends("layouts.app")

@section("title", "Bed Details — WellMeadows HMS")
@section("page_title", "Bed Profile: " . $bed->bed_no)

@section("content")
<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('wards.show', $bed->ward_no) }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Ward Details</a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 rounded-4 shadow-sm text-center p-5">
            @if($bed->status == 'Occupied' && $bed->currentPatient && $bed->currentPatient->patient)
                <div class="bg-danger bg-opacity-10 rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width:100px;height:100px;">
                    <i class="bi bi-person-fill text-danger" style="font-size:3rem;"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $bed->currentPatient->patient->first_name }} {{ $bed->currentPatient->patient->last_name }}</h4>
                <p class="text-muted mb-4"><a href="{{ route('patients.show', $bed->currentPatient->patient_no) }}" class="text-decoration-none">{{ $bed->currentPatient->patient_no }}</a></p>
                
                <div class="row text-start bg-light rounded-3 p-4 mb-4">
                    <div class="col-6 mb-3">
                        <small class="text-muted d-block mb-1">Ward</small>
                        <span class="fw-medium">{{ $bed->ward->ward_name }} ({{ $bed->ward_no }})</span>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted d-block mb-1">Status</small>
                        <span class="badge bg-danger rounded-pill px-3">Occupied</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block mb-1">Admitted On</small>
                        <span class="fw-medium">{{ \Carbon\Carbon::parse($bed->currentPatient->date_placed_in_ward)->format('d M Y') }}</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block mb-1">Expected Discharge</small>
                        <span class="fw-medium">{{ \Carbon\Carbon::parse($bed->currentPatient->date_expected_to_leave)->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-primary px-4"><i class="bi bi-file-medical me-2"></i>Medical Record</button>
                    <button class="btn btn-outline-danger px-4"><i class="bi bi-box-arrow-right me-2"></i>Process Discharge</button>
                </div>

            @else
                <div class="bg-success bg-opacity-10 rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width:100px;height:100px;">
                    <i class="bi bi-hospital-bed text-success" style="font-size:3rem;"></i>
                </div>
                <h4 class="fw-bold mb-1">Bed {{ $bed->bed_no }} is Available</h4>
                <p class="text-muted mb-4">{{ $bed->ward->ward_name }} Ward ({{ $bed->ward_no }})</p>
                
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-4 py-2 fs-6 mb-4">
                    Ready for Admission
                </span>

                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-primary px-4"><i class="bi bi-person-plus-fill me-2"></i>Admit Patient</button>
                    <button class="btn btn-outline-secondary px-4"><i class="bi bi-wrench me-2"></i>Mark for Maintenance</button>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
