@extends("layouts.app")

@section("title", "Schedule Appointment — WellMeadows HMS")
@section("page_title", "Schedule New Appointment")

@section("content")
<div class="mb-4">
    <a href="{{ route('appointments.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Appointments</a>
</div>

<div class="card border-0 rounded-4 shadow-sm" style="max-width: 800px;">
    <div class="card-header bg-white p-4 border-bottom-0">
        <h5 class="mb-0 fw-bold">Appointment Details</h5>
        <p class="text-muted small mb-0">Fill in the details below to schedule an appointment.</p>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Appointment Number</label>
                    <input type="text" name="appointment_no" class="form-control @error('appointment_no') is-invalid @enderror" value="{{ old('appointment_no', 'A' . rand(100, 999)) }}" required>
                    @error('appointment_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="Scheduled" {{ old('status') == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Patient</label>
                    <select name="patient_no" class="form-select @error('patient_no') is-invalid @enderror" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->patient_no }}" {{ old('patient_no') == $patient->patient_no ? 'selected' : '' }}>
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
                            <option value="{{ $staff->staff_no }}" {{ old('staff_no') == $staff->staff_no ? 'selected' : '' }}>
                                {{ $staff->first_name }} {{ $staff->last_name }} ({{ $staff->category ? $staff->category->title : 'Staff' }})
                            </option>
                        @endforeach
                    </select>
                    @error('staff_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Date</label>
                    <input type="date" name="date_of_appointment" class="form-control @error('date_of_appointment') is-invalid @enderror" value="{{ old('date_of_appointment', date('Y-m-d')) }}" required>
                    @error('date_of_appointment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Time</label>
                    <input type="time" name="time_of_appointment" class="form-control @error('time_of_appointment') is-invalid @enderror" value="{{ old('time_of_appointment', '09:00') }}" required>
                    @error('time_of_appointment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Examination Room</label>
                    <input type="text" name="examination_room" class="form-control @error('examination_room') is-invalid @enderror" value="{{ old('examination_room') }}" placeholder="e.g. Room 1" required>
                    @error('examination_room') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Clinic Number</label>
                    <input type="text" name="clinic_number" class="form-control @error('clinic_number') is-invalid @enderror" value="{{ old('clinic_number') }}" placeholder="Optional">
                    @error('clinic_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('appointments.index') }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">Schedule Appointment</button>
            </div>
        </form>
    </div>
</div>
@endsection
