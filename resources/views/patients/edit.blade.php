@extends("layouts.app")

@section("title", "Edit Patient — WellMeadows HMS")
@section("page_title", "Edit Patient Profile")

@section("content")
<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('patients.show', $patient->patient_no) }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Profile</a>
</div>

<div class="card border-0 rounded-4 shadow-sm" style="max-width: 800px;">
    <div class="card-header bg-white p-4 border-bottom-0 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold">Edit Patient: {{ $patient->patient_no }}</h5>
            <p class="text-muted small mb-0">Update the personal details for this patient.</p>
        </div>
        <div>
            <span class="badge bg-secondary">Registered: {{ \Carbon\Carbon::parse($patient->date_registered)->format('d M Y') }}</span>
        </div>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('patients.update', $patient->patient_no) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Local Doctor / Clinic</label>
                    <select name="clinic_number" class="form-select @error('clinic_number') is-invalid @enderror">
                        <option value="">Select Clinic (Optional)</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->clinic_number }}" {{ old('clinic_number', $patient->clinic_number) == $doctor->clinic_number ? 'selected' : '' }}>
                                {{ $doctor->full_name }} ({{ $doctor->clinic_number }})
                            </option>
                        @endforeach
                    </select>
                    @error('clinic_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6"></div> <!-- Spacer -->

                <div class="col-md-6">
                    <label class="form-label fw-medium small">First Name</label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $patient->first_name) }}" required>
                    @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Last Name</label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $patient->last_name) }}" required>
                    @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Marital Status</label>
                    <select name="marital_status" class="form-select @error('marital_status') is-invalid @enderror" required>
                        <option value="Single" {{ old('marital_status', $patient->marital_status) == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ old('marital_status', $patient->marital_status) == 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Divorced" {{ old('marital_status', $patient->marital_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                        <option value="Widowed" {{ old('marital_status', $patient->marital_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                    </select>
                    @error('marital_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Telephone Number</label>
                    <input type="text" name="telephone_number" class="form-control @error('telephone_number') is-invalid @enderror" value="{{ old('telephone_number', $patient->telephone_number) }}" required>
                    @error('telephone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium small">Home Address</label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" required>{{ old('address', $patient->address) }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <hr class="my-4">
            
            <h6 class="fw-bold mb-3">Next of Kin Details</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Full Name</label>
                    <input type="text" name="next_of_kin_name" class="form-control @error('next_of_kin_name') is-invalid @enderror" value="{{ old('next_of_kin_name', $patient->next_of_kin_name) }}" required>
                    @error('next_of_kin_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Relationship</label>
                    <input type="text" name="next_of_kin_relationship" class="form-control @error('next_of_kin_relationship') is-invalid @enderror" value="{{ old('next_of_kin_relationship', $patient->next_of_kin_relationship) }}" required>
                    @error('next_of_kin_relationship') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Telephone</label>
                    <input type="text" name="next_of_kin_telephone" class="form-control @error('next_of_kin_telephone') is-invalid @enderror" value="{{ old('next_of_kin_telephone', $patient->next_of_kin_telephone) }}" required>
                    @error('next_of_kin_telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-medium small">Address</label>
                    <textarea name="next_of_kin_address" class="form-control @error('next_of_kin_address') is-invalid @enderror" rows="2" required>{{ old('next_of_kin_address', $patient->next_of_kin_address) }}</textarea>
                    @error('next_of_kin_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('patients.show', $patient->patient_no) }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn btn-warning px-4 text-dark">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
