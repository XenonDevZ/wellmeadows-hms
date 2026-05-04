@extends("layouts.app")

@section("title", "Staff Directory — WellMeadows HMS")
@section("page_title", "Staff Directory")

@section("content")
<div class="container-fluid px-0">

    <!-- Header + Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex gap-2">
            <a href="{{ route('staff.create') }}" class="btn btn-primary px-4"><i class="bi bi-person-plus-fill me-2"></i>Add Staff Member</a>
            <button class="btn btn-outline-secondary"><i class="bi bi-clock-history me-2"></i>Staff Rota</button>
        </div>
        <div class="input-group shadow-sm rounded" style="max-width:280px;">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" id="staffSearch" class="form-control border-start-0 ps-0" placeholder="Search staff...">
        </div>
    </div>

    <!-- Staff Table -->
    <div class="card border-0 rounded-4 overflow-hidden shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle" id="staffTable">
                <thead>
                    <tr>
                        <th class="px-4">Staff No</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Tel No</th>
                        <th>Salary</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffMembers as $staff)
                        <tr>
                            <td class="fw-medium text-dark px-4">{{ $staff->staff_no }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @php
                                        // Generate color based on category for variety
                                        $colors = ['6366F1', '10B981', 'F59E0B', 'EC4899', '8B5CF6'];
                                        $color = $colors[crc32($staff->position_category_id) % count($colors)];
                                    @endphp
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($staff->first_name . ' ' . $staff->last_name) }}&background={{ $color }}&color=fff&size=32" class="rounded-circle" width="32" height="32">
                                    <div>
                                        <div class="fw-bold" style="font-size:0.85rem;">{{ $staff->first_name }} {{ $staff->last_name }}</div>
                                        <div class="text-muted" style="font-size:0.72rem;">{{ Str::limit($staff->address, 25) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if(str_contains($staff->category->title ?? '', 'Director'))
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">{{ $staff->category->title ?? 'Unknown' }}</span>
                                @elseif(str_contains($staff->category->title ?? '', 'Nurse'))
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">{{ $staff->category->title ?? 'Unknown' }}</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">{{ $staff->category->title ?? 'Unknown' }}</span>
                                @endif
                            </td>
                            <td style="font-size:0.85rem;">{{ $staff->telephone_number }}</td>
                            <td class="fw-medium" style="font-size:0.85rem;">£{{ number_format($staff->current_salary, 2) }}</td>
                            <td class="text-center">
                                <a href="{{ route('staff.show', $staff->staff_no) }}" class="btn btn-sm btn-light text-primary me-1" title="View"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('staff.edit', $staff->staff_no) }}" class="btn btn-sm btn-light text-warning me-1" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('staff.destroy', $staff->staff_no) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger" title="Delete" onclick="return confirm('Are you sure you want to remove this staff member?')"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No staff members found in the system.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center">
            @if($staffMembers->total() > 0)
                <small class="text-muted">Showing {{ $staffMembers->firstItem() }}–{{ $staffMembers->lastItem() }} of {{ $staffMembers->total() }} staff members</small>
            @else
                <small class="text-muted">Showing 0 staff members</small>
            @endif
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    @if ($staffMembers->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $staffMembers->previousPageUrl() }}">Previous</a></li>
                    @endif

                    @if ($staffMembers->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $staffMembers->nextPageUrl() }}">Next</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>

</div>
@endsection
