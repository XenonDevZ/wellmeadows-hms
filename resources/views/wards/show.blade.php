@extends("layouts.app")

@section("title", "Ward Details — WellMeadows HMS")
@section("page_title", "Ward Details: " . $ward->ward_name)

@section("content")
<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('wards.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Wards overview</a>
    <button class="btn btn-outline-primary btn-sm"><i class="bi bi-printer me-1"></i> Print Ward List</button>
</div>

<div class="row g-4">
    <!-- Ward Summary Card -->
    <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm p-4 h-100">
            <h4 class="fw-bold mb-1">{{ $ward->ward_name }}</h4>
            <p class="text-muted mb-4"><i class="bi bi-geo-alt me-1"></i>{{ $ward->location }} (Ward {{ $ward->ward_no }})</p>

            <h6 class="fw-bold mb-3">Capacity Overview</h6>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Total Beds</span>
                <span class="fw-bold">{{ $totalBeds }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-success"><i class="bi bi-hospital-bed me-2"></i>Available</span>
                <span class="fw-bold text-success">{{ $availableBeds }}</span>
            </div>
            <div class="d-flex justify-content-between mb-4">
                <span class="text-danger"><i class="bi bi-person-fill me-2"></i>Occupied</span>
                <span class="fw-bold text-danger">{{ $occupiedBeds }}</span>
            </div>

            <hr class="mb-4">

            <h6 class="fw-bold mb-3">Staff Details</h6>
            <div class="d-flex align-items-center gap-3 bg-light rounded-3 p-3">
                @php
                    $colors = ['6366F1', '10B981', 'F59E0B', 'EC4899', '8B5CF6'];
                    $color = $ward->chargeNurse ? $colors[crc32($ward->chargeNurse->position_category_id) % count($colors)] : '6c757d';
                    $nurseName = $ward->chargeNurse ? $ward->chargeNurse->first_name . ' ' . $ward->chargeNurse->last_name : 'Unassigned';
                @endphp
                <img src="https://ui-avatars.com/api/?name={{ urlencode($nurseName) }}&background={{ $color }}&color=fff&size=40" class="rounded-circle" width="40" height="40">
                <div>
                    <div class="fw-bold" style="font-size:0.9rem;">{{ $nurseName }}</div>
                    <div class="text-muted" style="font-size:0.75rem;">Charge Nurse</div>
                </div>
            </div>
            <div class="mt-3 text-muted small">
                <i class="bi bi-telephone me-1"></i> Ext: {{ $ward->telephone_extension }}
            </div>
        </div>
    </div>

    <!-- Active Admissions Table -->
    <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm h-100">
            <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Active Patients in Ward</h6>
                <div class="input-group input-group-sm rounded shadow-sm" style="max-width:200px;">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="Search patient...">
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4">Bed No</th>
                            <th>Patient No</th>
                            <th>Patient Name</th>
                            <th>Date Admitted</th>
                            <th>Expected Leave</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ward->beds->where('status', 'Occupied') as $bed)
                            @if($bed->currentPatient && $bed->currentPatient->patient)
                                <tr>
                                    <td class="ps-4 fw-bold text-danger">{{ $bed->bed_no }}</td>
                                    <td><a href="{{ route('patients.show', $bed->currentPatient->patient->patient_no) }}" class="text-decoration-none fw-medium">{{ $bed->currentPatient->patient->patient_no }}</a></td>
                                    <td>{{ $bed->currentPatient->patient->first_name }} {{ $bed->currentPatient->patient->last_name }}</td>
                                    <td style="font-size:0.85rem;">{{ \Carbon\Carbon::parse($bed->currentPatient->date_placed_in_ward)->format('d-M-y') }}</td>
                                    <td style="font-size:0.85rem;">{{ \Carbon\Carbon::parse($bed->currentPatient->date_expected_to_leave)->format('d-M-y') }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No active admissions in this ward.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
