@extends("layouts.app")

@section("title", "Patient Management — WellMeadows HMS")
@section("page_title", "Patient Management")

@section("content")
<div class="container-fluid px-0">

    <!-- Header + Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex gap-2">
            <a href="{{ route('patients.create') }}" class="btn btn-primary px-4"><i class="bi bi-person-plus-fill me-2"></i>Register Patient</a>
            <button class="btn btn-outline-secondary"><i class="bi bi-card-list me-2"></i>Waiting List</button>
        </div>
        <div class="input-group shadow-sm rounded" style="max-width:280px;">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" id="patientSearch" class="form-control border-start-0 ps-0" placeholder="Search patient by name or No...">
        </div>
    </div>

    <!-- Patient Table -->
    <div class="card border-0 rounded-4 overflow-hidden shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle" id="patientTable">
                <thead>
                    <tr>
                        <th class="px-4">Patient No</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Date Registered</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td class="fw-medium text-dark px-4">{{ $patient->patient_no }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($patient->first_name . ' ' . $patient->last_name) }}&background=6366F1&color=fff&size=32" class="rounded-circle" width="32" height="32">
                                    <div>
                                        <div class="fw-bold" style="font-size:0.85rem;">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                                        <div class="text-muted" style="font-size:0.72rem;">{{ Str::limit($patient->address, 25) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:0.85rem;">{{ $patient->telephone_number }}</td>
                            <td style="font-size:0.85rem;">{{ \Carbon\Carbon::parse($patient->date_registered)->format('d-M-y') }}</td>
                            <td>
                                @if($patient->currentAdmission)
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">In-Patient (Ward {{ $patient->currentAdmission->ward_no }})</span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Out-Patient</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('patients.show', $patient->patient_no) }}" class="btn btn-sm btn-light text-primary me-1" title="View"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('patients.edit', $patient->patient_no) }}" class="btn btn-sm btn-light text-warning me-1" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('patients.destroy', $patient->patient_no) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this patient?')"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No patients found in the system.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center">
            @if($patients->total() > 0)
                <small class="text-muted">Showing {{ $patients->firstItem() }}–{{ $patients->lastItem() }} of {{ $patients->total() }} patients</small>
            @else
                <small class="text-muted">Showing 0 patients</small>
            @endif
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    @if ($patients->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $patients->previousPageUrl() }}">Previous</a></li>
                    @endif

                    @if ($patients->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $patients->nextPageUrl() }}">Next</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>

</div>
@endsection
