@extends("layouts.app")

@section("title", "Staff Profile — WellMeadows HMS")
@section("page_title", "Staff Profile")

@section("content")
<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('staff.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Staff Directory</a>
    <a href="{{ route('staff.edit', $staff->staff_no) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil me-1"></i> Edit Profile</a>
</div>

<div class="row g-4">
    <!-- Profile Card -->
    <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm text-center p-4 h-100">
            @php
                $colors = ['6366F1', '10B981', 'F59E0B', 'EC4899', '8B5CF6'];
                $color = $colors[crc32($staff->position_category_id) % count($colors)];
            @endphp
            <img src="https://ui-avatars.com/api/?name={{ urlencode($staff->first_name . ' ' . $staff->last_name) }}&background={{ $color }}&color=fff&size=100" class="rounded-circle mx-auto mb-3" width="100" height="100">
            <h4 class="fw-bold mb-1">{{ $staff->first_name }} {{ $staff->last_name }}</h4>
            <p class="text-muted mb-3">{{ $staff->staff_no }}</p>
            
            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2 w-100 mb-4">
                <i class="bi bi-briefcase me-1"></i> {{ $staff->category->title ?? 'Uncategorized' }}
            </span>

            <div class="text-start mt-2">
                <p class="small text-muted mb-1">Sex</p>
                <p class="fw-medium mb-3">{{ $staff->sex == 'M' ? 'Male' : 'Female' }}</p>

                <p class="small text-muted mb-1">National Insurance No</p>
                <p class="fw-medium mb-3">{{ $staff->nin }}</p>

                <p class="small text-muted mb-1">Contact</p>
                <p class="fw-medium mb-3">{{ $staff->telephone_number }}</p>
                
                <p class="small text-muted mb-1">Address</p>
                <p class="fw-medium mb-0">{{ $staff->address }}</p>
            </div>
        </div>
    </div>

    <!-- Details Column -->
    <div class="col-lg-8">
        <!-- Employment Info -->
        <div class="card border-0 rounded-4 shadow-sm mb-4">
            <div class="card-header bg-white p-4 border-bottom-0">
                <h6 class="fw-bold mb-0">Employment & Salary</h6>
            </div>
            <div class="card-body px-4 pb-4 pt-0">
                <div class="row bg-light rounded-3 p-3">
                    <div class="col-md-4">
                        <p class="small text-muted mb-1">Salary Scale</p>
                        <p class="fw-medium mb-0">{{ $staff->salary_scale }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="small text-muted mb-1">Current Salary</p>
                        <p class="fw-medium mb-0">£{{ number_format($staff->current_salary, 2) }} / yr</p>
                    </div>
                    <div class="col-md-4">
                        <p class="small text-muted mb-1">Joined System</p>
                        <p class="fw-medium mb-0">{{ \Carbon\Carbon::parse($staff->created_at)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Managed Wards (If Charge Nurse) -->
        @if($staff->managedWards->count() > 0)
        <div class="card border-0 rounded-4 shadow-sm mb-4 border-start border-4 border-success">
            <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-success"><i class="bi bi-hospital me-2"></i>Managed Wards</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4">Ward No</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Beds</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staff->managedWards as $ward)
                        <tr>
                            <td class="ps-4 fw-medium text-dark">{{ $ward->ward_no }}</td>
                            <td>{{ $ward->ward_name }}</td>
                            <td>{{ $ward->location }}</td>
                            <td>{{ $ward->total_beds }} total</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Qualifications -->
        <div class="card border-0 rounded-4 shadow-sm mb-4">
            <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Qualifications</h6>
                <button class="btn btn-sm btn-light"><i class="bi bi-plus"></i> Add</button>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4">Type</th>
                            <th>Institution</th>
                            <th>Date Earned</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff->qualifications as $qual)
                        <tr>
                            <td class="ps-4 fw-medium">{{ $qual->type }}</td>
                            <td>{{ $qual->institution_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($qual->date_earned)->format('M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">No qualifications recorded.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Work Experience -->
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Work Experience</h6>
                <button class="btn btn-sm btn-light"><i class="bi bi-plus"></i> Add</button>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4">Organization</th>
                            <th>Position</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff->workExperiences as $exp)
                        <tr>
                            <td class="ps-4 fw-medium">{{ $exp->organization_name }}</td>
                            <td>{{ $exp->position }}</td>
                            <td>{{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} — {{ \Carbon\Carbon::parse($exp->end_date)->format('M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">No prior work experience recorded.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
