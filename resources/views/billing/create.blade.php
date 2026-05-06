@extends("layouts.app")

@section("title", "Create Bill — WellMeadows HMS")
@section("page_title", "Create Patient Bill")

@section("content")
<div class="mb-4">
    <a href="{{ route('billing.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Billing</a>
</div>

@if($errors->any())
<div class="alert alert-danger mb-4">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card border-0 rounded-4 shadow-sm" style="max-width: 800px;">
    <div class="card-header bg-white p-4 border-bottom">
        <h5 class="mb-0 fw-bold">Billing Details</h5>
        <p class="text-muted small mb-0">Record a new financial charge for a patient.</p>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('billing.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-12">
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
                    <label class="form-label fw-medium small">Bill Date</label>
                    <input type="date" name="bill_date" class="form-control @error('bill_date') is-invalid @enderror"
                           value="{{ old('bill_date', date('Y-m-d')) }}" required>
                    @error('bill_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="Unpaid" {{ old('status', 'Unpaid') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="Paid" {{ old('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium small">Total Amount (£)</label>
                    <div class="input-group">
                        <span class="input-group-text">£</span>
                        <input type="number" step="0.01" name="total_amount"
                               class="form-control @error('total_amount') is-invalid @enderror"
                               value="{{ old('total_amount') }}" placeholder="0.00" min="0" required>
                        @error('total_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
                <a href="{{ route('billing.index') }}" class="btn btn-light px-4">Cancel</a>
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Create Bill</button>
            </div>
        </form>
    </div>
</div>
@endsection
