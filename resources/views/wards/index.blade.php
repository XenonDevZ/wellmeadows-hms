@extends("layouts.app")

@section("title", "Ward & Bed Management — WellMeadows HMS")
@section("page_title", "Ward & Bed Management")

@section("content")
<div class="container-fluid px-0">

    <!-- Ward Cards Grid -->
    <div class="row g-4">
        @forelse($wards as $ward)
            @php
                $occupiedBeds = $ward->beds->where('status', 'Occupied')->count();
                $availableBeds = $ward->total_beds - $occupiedBeds;
                $occupancyPercentage = $ward->total_beds > 0 ? ($occupiedBeds / $ward->total_beds) * 100 : 0;
                
                // Color Logic
                $badgeClass = $occupancyPercentage >= 90 ? 'danger' : ($occupancyPercentage >= 70 ? 'warning' : 'success');
                $progressColor = $occupancyPercentage >= 90 ? '#EF4444' : ($occupancyPercentage >= 70 ? '#F59E0B' : '#10B981');
            @endphp
            
            <div class="col-md-6">
                <div class="card border-0 rounded-4 h-100 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge bg-{{ $badgeClass }} bg-opacity-10 text-{{ $badgeClass }} rounded-pill px-3 mb-2">Ward {{ $ward->ward_no }}</span>
                                <h5 class="fw-bold mb-1">{{ $ward->ward_name }}</h5>
                                <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $ward->location }}</small>
                            </div>
                            <a href="{{ route('wards.show', $ward->ward_no) }}" class="btn btn-sm btn-outline-primary">View Details <i class="bi bi-arrow-right ms-1"></i></a>
                        </div>

                        <!-- Occupancy bar -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span style="font-size:0.82rem;font-weight:600;">Bed Occupancy</span>
                                <span style="font-size:0.75rem;font-weight:600;color:var(--text-muted);">{{ $occupiedBeds }}/{{ $ward->total_beds }} ({{ round($occupancyPercentage) }}%)</span>
                            </div>
                            <div class="progress" style="height:6px;">
                                <div class="progress-bar" role="progressbar" style="width:{{ $occupancyPercentage }}%;background:{{ $progressColor }};border-radius:100px;"></div>
                            </div>
                        </div>

                        <div class="d-flex gap-4 mt-3">
                            <div class="text-center">
                                <div class="fs-5 fw-bold" style="color:#10B981;">{{ $availableBeds }}</div>
                                <small class="text-muted">Available</small>
                            </div>
                            <div class="text-center">
                                <div class="fs-5 fw-bold" style="color:#EF4444;">{{ $occupiedBeds }}</div>
                                <small class="text-muted">Occupied</small>
                            </div>
                            <div class="vr"></div>
                            <div class="ms-2">
                                <div style="font-size:0.85rem;font-weight:600;">{{ $ward->chargeNurse->full_name ?? 'Unassigned' }}</div>
                                <small class="text-muted">Charge Nurse</small>
                            </div>
                        </div>

                        <!-- Bed Grid -->
                        <div class="mt-3 p-3 rounded-3" style="background:var(--bg-body);">
                            <div class="row g-2">
                                @foreach($ward->beds as $bed)
                                    <div class="col-2">
                                        <a href="{{ route('wards.bed', [$ward->ward_no, $bed->bed_no]) }}" class="text-decoration-none">
                                            @if($bed->status == 'Occupied' && $bed->currentPatient)
                                                <div class="p-2 bg-white border rounded text-center" style="border-radius:var(--radius-md)!important;border-color:#EF4444!important;border-width:2px!important;transition:all 0.2s ease;">
                                                    <i class="bi bi-person-fill" style="color:#EF4444;"></i>
                                                    <div class="fw-bold text-dark" style="font-size:0.7rem;">{{ $bed->bed_no }}</div>
                                                    <div style="font-size:0.55rem;color:#EF4444;font-weight:600;">{{ $bed->currentPatient->patient_no }}</div>
                                                </div>
                                            @else
                                                <div class="p-2 bg-white border rounded text-center" style="border-radius:var(--radius-md)!important;transition:all 0.2s ease;">
                                                    <i class="bi bi-hospital-bed" style="color:#10B981;"></i>
                                                    <div class="fw-bold text-dark" style="font-size:0.7rem;">{{ $bed->bed_no }}</div>
                                                    <div class="text-muted" style="font-size:0.55rem;">Open</div>
                                                </div>
                                            @endif
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-2 d-flex gap-3" style="font-size:0.7rem;">
                                <span><i class="bi bi-hospital-bed me-1" style="color:#10B981;"></i>Available</span>
                                <span><i class="bi bi-person-fill me-1" style="color:#EF4444;"></i>Occupied</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">No wards found in the system.</p>
            </div>
        @endforelse
    </div>

</div>

<style>
    /* Add slight hover effect to bed buttons */
    .row.g-2 .col-2 > a > div:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }
</style>
@endsection
