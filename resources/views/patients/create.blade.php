@extends("layouts.app")

@section("title", "Register Patient — WellMeadows HMS")
@section("page_title", "Register New Patient")

@section("content")
<div class="mb-4">
    <a href="{{ route('patients.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Patients</a>
</div>

<div class="card border-0 rounded-4 shadow-sm" style="max-width: 800px;">
    <div class="card-header bg-white p-4 border-bottom-0">
        <h5 class="mb-0 fw-bold">Patient Information</h5>
        <p class="text-muted small mb-0">Enter the personal details to register a new patient.</p>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('patients.store') }}" method="POST">
            @csrf
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Patient Number</label>
                    <input type="text" name="patient_no" class="form-control @error('patient_no') is-invalid @enderror" value="{{ old('patient_no') }}" placeholder="e.g. P10605" required>
                    @error('patient_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Local Doctor / Clinic</label>
                    <select name="clinic_number" class="form-select @error('clinic_number') is-invalid @enderror">
                        <option value="">Select Clinic (Optional)</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->clinic_number }}" {{ old('clinic_number') == $doctor->clinic_number ? 'selected' : '' }}>{{ $doctor->full_name }} ({{ $doctor->clinic_number }})</option>
                        @endforeach
                    </select>
                    @error('clinic_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">First Name</label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required>
                    @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Last Name</label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required>
                    @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-medium small">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}" required>
                    @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium small">Sex</label>
                    <select name="sex" class="form-select @error('sex') is-invalid @enderror" required>
                        <option value="M" {{ old('sex') == 'M' ? 'selected' : '' }}>Male</option>
                        <option value="F" {{ old('sex') == 'F' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('sex') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium small">Marital Status</label>
                    <select name="marital_status" class="form-select @error('marital_status') is-invalid @enderror" required>
                        <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Divorced" {{ old('marital_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                        <option value="Widowed" {{ old('marital_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                    </select>
                    @error('marital_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Telephone Number</label>
                    <input type="text" name="telephone_number" class="form-control @error('telephone_number') is-invalid @enderror" value="{{ old('telephone_number') }}" required>
                    @error('telephone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Date Registered</label>
                    <input type="date" name="date_registered" class="form-control @error('date_registered') is-invalid @enderror" value="{{ old('date_registered', date('Y-m-d')) }}" required>
                    @error('date_registered') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium small">Home Address</label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" required>{{ old('address') }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <hr class="my-4">
            
            <h6 class="fw-bold mb-3">Next of Kin Details</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Full Name</label>
                    <input type="text" name="next_of_kin_name" class="form-control @error('next_of_kin_name') is-invalid @enderror" value="{{ old('next_of_kin_name') }}" required>
                    @error('next_of_kin_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Relationship</label>
                    <input type="text" name="next_of_kin_relationship" class="form-control @error('next_of_kin_relationship') is-invalid @enderror" value="{{ old('next_of_kin_relationship') }}" placeholder="e.g. Spouse, Parent" required>
                    @error('next_of_kin_relationship') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Telephone</label>
                    <input type="text" name="next_of_kin_telephone" class="form-control @error('next_of_kin_telephone') is-invalid @enderror" value="{{ old('next_of_kin_telephone') }}" required>
                    @error('next_of_kin_telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-medium small">Address</label>
                    <textarea name="next_of_kin_address" class="form-control @error('next_of_kin_address') is-invalid @enderror" rows="2" required>{{ old('next_of_kin_address') }}</textarea>
                    @error('next_of_kin_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('patients.index') }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">Register Patient</button>
            </div>
        </form>
    </div>
</div>
@endsection
