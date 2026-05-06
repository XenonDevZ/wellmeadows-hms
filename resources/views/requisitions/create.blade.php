@extends("layouts.app")

@section("title", "New Requisition — WellMeadows HMS")
@section("page_title", "New Ward Requisition")

@section("content")
<div class="mb-4">
    <a href="{{ route('billing.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Requisitions</a>
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
        <h5 class="mb-0 fw-bold">Requisition Details</h5>
        <p class="text-muted small mb-0">Order new supplies for a hospital ward.</p>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('requisitions.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium small">Destination Ward</label>
                    <select name="ward_no" class="form-select @error('ward_no') is-invalid @enderror" required>
                        <option value="">Select Ward</option>
                        @foreach($wards as $ward)
                            <option value="{{ $ward->ward_no }}" {{ old('ward_no') == $ward->ward_no ? 'selected' : '' }}>
                                {{ $ward->ward_name }} ({{ $ward->ward_no }})
                            </option>
                        @endforeach
                    </select>
                    @error('ward_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Requesting Staff Member</label>
                    <select name="staff_no" class="form-select @error('staff_no') is-invalid @enderror" required>
                        <option value="">Select Staff</option>
                        @foreach($staffMembers as $staff)
                            <option value="{{ $staff->staff_no }}" {{ old('staff_no') == $staff->staff_no ? 'selected' : '' }}>
                                {{ $staff->first_name }} {{ $staff->last_name }} ({{ $staff->staff_no }})
                            </option>
                        @endforeach
                    </select>
                    @error('staff_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Date Ordered</label>
                    <input type="date" name="date_ordered"
                           class="form-control @error('date_ordered') is-invalid @enderror"
                           value="{{ old('date_ordered', date('Y-m-d')) }}" required>
                    @error('date_ordered') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium small">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="Pending" {{ old('status', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ old('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Delivered" {{ old('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium small">Requested Items <span class="text-danger">*</span></label>
                    @error('items') <div class="text-danger small mb-1">{{ $message }}</div> @enderror
                    <div class="border rounded-3 p-3 @error('items') border-danger @enderror" style="max-height: 250px; overflow-y: auto;">
                        @forelse($items as $item)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox"
                                       name="items[]" value="{{ $item->item_no }}"
                                       id="item_{{ $item->item_no }}"
                                       {{ is_array(old('items')) && in_array($item->item_no, old('items')) ? 'checked' : '' }}>
                                <label class="form-check-label d-flex justify-content-between w-100" for="item_{{ $item->item_no }}">
                                    <span>{{ $item->name }}</span>
                                    <span class="text-muted small ms-3">
                                        In Stock: {{ $item->quantity_in_stock }}
                                        @if($item->quantity_in_stock <= $item->reorder_level)
                                            <span class="badge bg-danger bg-opacity-10 text-danger ms-1">Low</span>
                                        @endif
                                    </span>
                                </label>
                            </div>
                        @empty
                            <p class="text-muted mb-0 text-center">No items in inventory.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
                <a href="{{ route('billing.index') }}" class="btn btn-light px-4">Cancel</a>
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-send me-2"></i>Submit Requisition</button>
            </div>
        </form>
    </div>
</div>
@endsection
