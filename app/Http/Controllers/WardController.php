<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Models\Bed;
use Illuminate\Http\Request;

class WardController extends Controller
{
    /**
     * Display a listing of all wards with their bed capacities.
     */
    public function index()
    {
        $wards = Ward::with('chargeNurse')->get();
        return view('wards.index', compact('wards'));
    }

    /**
     * Show the detailed view of a specific ward, including its beds and current patients.
     */
    public function show($id)
    {
        $ward = Ward::with(['chargeNurse', 'beds.currentPatient.patient'])->findOrFail($id);
        
        $totalBeds = $ward->total_beds;
        $occupiedBeds = $ward->beds->where('status', 'Occupied')->count();
        $availableBeds = $ward->beds->where('status', 'Available')->count();

        return view('wards.show', compact('ward', 'totalBeds', 'occupiedBeds', 'availableBeds'));
    }

    /**
     * Display a specific bed's history and current occupancy.
     */
    public function showBed($ward_id, $bed_no)
    {
        $bed = Bed::with(['currentPatient.patient', 'ward'])->where('ward_no', $ward_id)->where('bed_no', $bed_no)->firstOrFail();
        
        return view('wards.bed', compact('bed'));
    }
}
