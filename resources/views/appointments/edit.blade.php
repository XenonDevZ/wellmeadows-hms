@extends("layouts.app")

@section("title", "Edit Appointment — WellMeadows HMS")
@section("page_title", "Edit Appointment")

@section("content")
<div class="mb-4">
    <a href="{{ route('appointments.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Appointments</a>
</div>

<div class="card border-0 rounded-4 shadow-sm" style="max-width: 800px;">
    <div class="card-header bg-white p-4 border-bottom-0 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold">Edit Appointment: {{ $appointment->appointment_no }}</h5>
            <p class="text-muted small mb-0">Update the scheduling details.</p>
        </div>
        <div>
            @if($appointment->status == 'Completed')
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Completed</span>
            @elseif($appointment->status == 'Scheduled')
                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">Scheduled</span>
            @else
                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">{{ $appointment->status }}</span>
            @endif
        </div>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('appointments.update', $appointment->appointment_no) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="Scheduled" {{ old('status', $appointment->status) == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="Completed" {{ old('status', $appointment->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ old('status', $appointment->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6"></div>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Patient</label>
                    <select name="patient_no" class="form-select @error('patient_no') is-invalid @enderror" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->patient_no }}" {{ old('patient_no', $appointment->patient_no) == $patient->patient_no ? 'selected' : '' }}>
                                {{ $patient->first_name }} {{ $patient->last_name }} ({{ $patient->patient_no }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Consulting Staff</label>
                    <select name="staff_no" class="form-select @error('staff_no') is-invalid @enderror" required>
                        <option value="">Select Staff Member</option>
                        @foreach($staffMembers as $staff)
                            <option value="{{ $staff->staff_no }}" {{ old('staff_no', $appointment->staff_no) == $staff->staff_no ? 'selected' : '' }}>
                                {{ $staff->first_name }} {{ $staff->last_name }} ({{ $staff->category ? $staff->category->title : 'Staff' }})
                            </option>
                        @endforeach
                    </select>
                    @error('staff_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Date</label>
                    <input type="date" name="date_of_appointment" class="form-control @error('date_of_appointment') is-invalid @enderror" value="{{ old('date_of_appointment', $appointment->date_of_appointment ? \Carbon\Carbon::parse($appointment->date_of_appointment)->format('Y-m-d') : '') }}" required>
                    @error('date_of_appointment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Time</label>
                    <input type="time" name="time_of_appointment" class="form-control @error('time_of_appointment') is-invalid @enderror" value="{{ old('time_of_appointment', $appointment->time_of_appointment ? \Carbon\Carbon::parse($appointment->time_of_appointment)->format('H:i') : '') }}" required>
                    @error('time_of_appointment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Examination Room</label>
                    <input type="text" name="examination_room" class="form-control @error('examination_room') is-invalid @enderror" value="{{ old('examination_room', $appointment->examination_room) }}" required>
                    @error('examination_room') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Clinic Number</label>
                    <input type="text" name="clinic_number" class="form-control @error('clinic_number') is-invalid @enderror" value="{{ old('clinic_number', $appointment->clinic_number) }}">
                    @error('clinic_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('appointments.index') }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn btn-warning px-4 text-dark">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
