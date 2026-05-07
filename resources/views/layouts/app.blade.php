<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WellMeadows Hospital Management System')</title>
    <meta name="description" content="WellMeadows Hospital Management System">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- HTMX for Smooth SPA-like Navigation -->
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <style>
        /* Smooth fade transition for page swaps */
        body { transition: opacity 0.2s ease-in-out; }
        body.htmx-swapping { opacity: 0; }
    </style>
</head>
<body hx-boost="true">
    <div class="d-flex" id="wrapper">

        <!-- ─── Sidebar ─────────────────────────────────────────────── -->
        <div class="sidebar-wrapper" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 fs-5 fw-bold text-uppercase border-bottom">
                <i class="bi bi-hospital fs-4 me-1"></i> WellMeadows
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="/dashboard" class="list-group-item list-group-item-action bg-transparent {{ Request::is('dashboard') || Request::is('/') ? 'active' : 'second-text fw-bold' }}">
                    <i class="bi bi-grid-1x2-fill me-2"></i>Dashboard
                </a>
                <a href="/patients" class="list-group-item list-group-item-action bg-transparent {{ Request::is('patients*') ? 'active' : 'second-text fw-bold' }}">
                    <i class="bi bi-people-fill me-2"></i>Patient Management
                </a>
                <a href="/staff" class="list-group-item list-group-item-action bg-transparent {{ Request::is('staff*') ? 'active' : 'second-text fw-bold' }}">
                    <i class="bi bi-person-badge-fill me-2"></i>Staff Management
                </a>
                <a href="/wards" class="list-group-item list-group-item-action bg-transparent {{ Request::is('wards*') ? 'active' : 'second-text fw-bold' }}">
                    <i class="bi bi-building-fill me-2"></i>Ward & Bed Mgmt
                </a>
                <a href="/appointments" class="list-group-item list-group-item-action bg-transparent {{ Request::is('appointments*') ? 'active' : 'second-text fw-bold' }}">
                    <i class="bi bi-clipboard2-pulse-fill me-2"></i>Appointments
                </a>
                <a href="/billing" class="list-group-item list-group-item-action bg-transparent {{ Request::is('billing*') ? 'active' : 'second-text fw-bold' }}">
                    <i class="bi bi-receipt-cutoff me-2"></i>Billing & Requisition
                </a>
                <a href="/reports" class="list-group-item list-group-item-action bg-transparent {{ Request::is('reports*') ? 'active' : 'second-text fw-bold' }}">
                    <i class="bi bi-file-earmark-bar-graph me-2"></i>Reports
                </a>
            </div>

            <!-- Sidebar Footer: Logout -->
            <div class="mt-auto p-3" style="border-top:1px solid rgba(255,255,255,0.06);">
                <form action="{{ route('logout') }}" method="POST" hx-boost="false">
                    @csrf
                    <button type="submit" class="btn w-100 d-flex align-items-center justify-content-center gap-2" style="background:rgba(239,68,68,0.1);color:#F87171;border:1px solid rgba(239,68,68,0.15);border-radius:8px;font-size:0.85rem;font-weight:500;padding:0.6rem;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- ─── Main Content ────────────────────────────────────────── -->
        <div id="page-content-wrapper" class="w-100">
            <nav class="navbar navbar-expand-lg py-3 px-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-text-left fs-4 me-3" id="menu-toggle" style="cursor:pointer;"></i>
                    <h2 class="fs-4 m-0">@yield('page_title', 'Dashboard')</h2>
                </div>
                <div class="ms-auto d-flex align-items-center gap-3">
                    <span class="text-muted" style="font-size:0.8rem;">
                        <i class="bi bi-calendar3 me-1"></i> {{ now()->format('D, d M Y') }}
                    </span>
                    <div class="d-flex align-items-center gap-2 ps-3" style="border-left: 1px solid var(--border);">
                        @auth
                            @php
                                $staff = auth()->user()->staff;
                                $fullName = $staff ? $staff->first_name . ' ' . $staff->last_name : 'Admin User';
                                $position = $staff && $staff->category ? $staff->category->title : 'Administrator';
                                $colors = ['6366F1', '10B981', 'F59E0B', 'EC4899', '8B5CF6'];
                                $color = $staff ? $colors[crc32($staff->position_category_id ?? '') % count($colors)] : '6366F1';
                            @endphp
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($fullName) }}&background={{ $color }}&color=fff&size=32"
                                 class="rounded-circle" width="32" height="32" alt="Avatar">
                            <div style="line-height:1.2;">
                                <div style="font-size:0.8rem;font-weight:600;">{{ $fullName }}</div>
                                <div style="font-size:0.65rem;color:var(--text-muted);">{{ $position }}</div>
                            </div>
                        @else
                            <img src="https://ui-avatars.com/api/?name=Guest&background=6c757d&color=fff&size=32"
                                 class="rounded-circle" width="32" height="32" alt="Avatar">
                            <div style="line-height:1.2;">
                                <div style="font-size:0.8rem;font-weight:600;">Guest</div>
                                <div style="font-size:0.65rem;color:var(--text-muted);">Please Login</div>
                            </div>
                        @endauth
                    </div>
                </div>
            </nav>

            <div class="container-fluid px-4 py-3">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById("menu-toggle").onclick = function () {
            document.getElementById("wrapper").classList.toggle("toggled");
        };

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        @if($errors->any())
            Toast.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Please check the form for errors.'
            });
        @endif
    </script>
    @stack('scripts')
</body>
</html>
