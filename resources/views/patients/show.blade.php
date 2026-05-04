@extends("layouts.app")

@section("title", "Patient Profile — WellMeadows HMS")
@section("page_title", "Patient Profile")

@section("content")
<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('patients.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Patients</a>
    <a href="{{ route('patients.edit', $patient->patient_no) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil me-1"></i> Edit Patient</a>
</div>

<div class="row g-4">
    <!-- Profile Card -->
    <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm text-center p-4 h-100">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($patient->first_name . ' ' . $patient->last_name) }}&background=6366F1&color=fff&size=100" class="rounded-circle mx-auto mb-3" width="100" height="100">
            <h4 class="fw-bold mb-1">{{ $patient->first_name }} {{ $patient->last_name }}</h4>
            <p class="text-muted mb-3">{{ $patient->patient_no }}</p>
            
            @if($patient->currentAdmission)
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 w-100 mb-3">
                    <i class="bi bi-hospital me-1"></i> In-Patient (Ward {{ $patient->currentAdmission->ward_no }})
                </span>
            @else
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 w-100 mb-3">
                    <i class="bi bi-house me-1"></i> Out-Patient
                </span>
            @endif

            <div class="text-start mt-4">
                <p class="small text-muted mb-1">Sex</p>
                <p class="fw-medium mb-3">{{ $patient->sex == 'M' ? 'Male' : 'Female' }}</p>
                
                <p class="small text-muted mb-1">Date of Birth</p>
                <p class="fw-medium mb-3">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d M Y') }} ({{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} yrs)</p>

                <p class="small text-muted mb-1">Contact</p>
                <p class="fw-medium mb-3">{{ $patient->telephone_number }}</p>
                
                <p class="small text-muted mb-1">Address</p>
                <p class="fw-medium mb-0">{{ $patient->address }}</p>
            </div>
        </div>
    </div>

    <!-- Details Column -->
    <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm mb-4">
            <div class="card-header bg-white p-4 border-bottom-0">
                <h6 class="fw-bold mb-0">Emergency Contact (Next of Kin)</h6>
            </div>
            <div class="card-body px-4 pb-4 pt-0">
                <div class="row bg-light rounded-3 p-3">
                    <div class="col-md-4">
                        <p class="small text-muted mb-1">Name</p>
                        <p class="fw-medium mb-0">{{ $patient->next_of_kin_name }} ({{ $patient->next_of_kin_relationship }})</p>
                    </div>
                    <div class="col-md-4">
                        <p class="small text-muted mb-1">Telephone</p>
                        <p class="fw-medium mb-0">{{ $patient->next_of_kin_telephone }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="small text-muted mb-1">Address</p>
                        <p class="fw-medium mb-0" style="font-size:0.85rem;">{{ $patient->next_of_kin_address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admissions & Appointments -->
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Appointments</h6>
                <button class="btn btn-sm btn-primary"><i class="bi bi-calendar-plus me-1"></i> Book</button>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4">Appt No</th>
                            <th>Date & Time</th>
                            <th>Doctor (Staff)</th>
                            <th>Room</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patient->appointments as $appt)
                        <tr>
                            <td class="ps-4 fw-medium">{{ $appt->appointment_no }}</td>
                            <td style="font-size:0.85rem;">{{ \Carbon\Carbon::parse($appt->date_of_appointment)->format('d-M-y') }} <br><span class="text-muted">{{ \Carbon\Carbon::parse($appt->time_of_appointment)->format('H:i') }}</span></td>
                            <td style="font-size:0.85rem;">{{ $appt->staff->first_name ?? '' }} {{ $appt->staff->last_name ?? '' }}</td>
                            <td>{{ $appt->examination_room }}</td>
                            <td><span class="badge bg-secondary">{{ $appt->status ?? 'Scheduled' }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No appointments found for this patient.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
