@extends("layouts.app")

@section("title", "Add Staff Member — WellMeadows HMS")
@section("page_title", "Add Staff Member")

@section("content")
<div class="mb-4">
    <a href="{{ route('staff.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Staff Directory</a>
</div>

<div class="card border-0 rounded-4 shadow-sm" style="max-width: 800px;">
    <div class="card-header bg-white p-4 border-bottom-0">
        <h5 class="mb-0 fw-bold">Staff Information</h5>
        <p class="text-muted small mb-0">Enter the details for the new staff member.</p>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('staff.store') }}" method="POST">
            @csrf
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Staff Number</label>
                    <input type="text" name="staff_no" class="form-control @error('staff_no') is-invalid @enderror" value="{{ old('staff_no') }}" placeholder="e.g. S10131" required>
                    @error('staff_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">National Insurance No (NIN)</label>
                    <input type="text" name="nin" class="form-control @error('nin') is-invalid @enderror" value="{{ old('nin') }}" placeholder="e.g. JL 123456 C" required>
                    @error('nin') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}" required>
                    @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Sex</label>
                    <select name="sex" class="form-select @error('sex') is-invalid @enderror" required>
                        <option value="M" {{ old('sex') == 'M' ? 'selected' : '' }}>Male</option>
                        <option value="F" {{ old('sex') == 'F' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('sex') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium small">Home Address</label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" required>{{ old('address') }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Telephone Number</label>
                    <input type="text" name="telephone_number" class="form-control @error('telephone_number') is-invalid @enderror" value="{{ old('telephone_number') }}" required>
                    @error('telephone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <hr class="col-12 my-4">

                <h6 class="fw-bold col-12 mb-2">Employment Details</h6>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Position Category</label>
                    <select name="position_category_id" class="form-select @error('position_category_id') is-invalid @enderror" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}" {{ old('position_category_id') == $category->category_id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('position_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-6"></div> <!-- spacer -->

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Salary Scale</label>
                    <input type="text" name="salary_scale" class="form-control @error('salary_scale') is-invalid @enderror" value="{{ old('salary_scale') }}" placeholder="e.g. Band 5, Band 6" required>
                    @error('salary_scale') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Current Salary (£)</label>
                    <input type="number" step="0.01" name="current_salary" class="form-control @error('current_salary') is-invalid @enderror" value="{{ old('current_salary') }}" placeholder="e.g. 35000.00" required>
                    @error('current_salary') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('staff.index') }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">Add Staff Member</button>
            </div>
        </form>
    </div>
</div>
@endsection
