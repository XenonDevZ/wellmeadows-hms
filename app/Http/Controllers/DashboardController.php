<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Bed;
use App\Models\PatientAppointment;
use App\Models\Item;
use App\Models\InPatient;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard with aggregated metrics.
     */
    public function index()
    {
        // 1. Total Patients Count
        $totalPatients = Patient::count();

        // 2. Available Beds Count
        $availableBeds = Bed::where('status', 'Available')->count();

        // 3. Appointments Today/Upcoming
        $upcomingAppointments = PatientAppointment::where('status', 'Scheduled')
            ->whereDate('date_of_appointment', '>=', now()->toDateString())
            ->count();

        // 4. Low Stock Items (Items where quantity <= reorder_level)
        // Using raw query logic for performance on simple comparison
        $lowStockItems = Item::whereColumn('quantity_in_stock', '<=', 'reorder_level')->count();

        // 5. Recent Admissions (In-Patients recently placed in a ward)
        $recentAdmissions = InPatient::with(['patient', 'ward', 'bed'])
            ->whereNotNull('date_placed_in_ward')
            ->whereNull('actual_date_left')
            ->latest('date_placed_in_ward')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPatients',
            'availableBeds',
            'upcomingAppointments',
            'lowStockItems',
            'recentAdmissions'
        ));
    }
}
