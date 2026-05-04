<?php

namespace App\Http\Controllers;

use App\Models\PatientAppointment;
use App\Models\Patient;
use App\Models\Staff;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PatientAppointment::with(['patient', 'staff']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('patient', function($q) use ($search) {
                $q->where('first_name', 'ilike', "%{$search}%")
                  ->orWhere('last_name', 'ilike', "%{$search}%");
            })->orWhere('appointment_no', 'ilike', "%{$search}%");
        }

        $appointments = $query->orderBy('date_of_appointment', 'desc')
                              ->orderBy('time_of_appointment', 'desc')
                              ->paginate(10);

        $today = Carbon::today();

        $stats = [
            'total_today' => PatientAppointment::whereDate('date_of_appointment', $today)->count(),
            'completed' => PatientAppointment::where('status', 'Completed')->count(),
            'upcoming' => PatientAppointment::where('status', 'Scheduled')
                                            ->whereDate('date_of_appointment', '>=', $today)
                                            ->count(),
            'cancelled' => PatientAppointment::where('status', 'Cancelled')->count(),
        ];

        return view('appointments.index', compact('appointments', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::orderBy('last_name')->get();
        // Get doctors/consultants (assuming category IDs 5, 8, etc., but we'll fetch all medical staff for simplicity)
        $staffMembers = Staff::with('category')->orderBy('last_name')->get();

        return view('appointments.create', compact('patients', 'staffMembers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_no' => 'required|string|unique:patient_appointment,appointment_no|max:10',
            'patient_no' => 'required|exists:patient,patient_no',
            'staff_no' => 'required|exists:staff,staff_no',
            'clinic_number' => 'nullable|string|max:10',
            'date_of_appointment' => 'required|date',
            'time_of_appointment' => 'required|date_format:H:i',
            'examination_room' => 'required|string|max:20',
            'status' => 'required|string|in:Scheduled,Completed,Cancelled'
        ]);

        PatientAppointment::create($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment scheduled successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = PatientAppointment::with(['patient', 'staff'])->findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $appointment = PatientAppointment::findOrFail($id);
        $patients = Patient::orderBy('last_name')->get();
        $staffMembers = Staff::orderBy('last_name')->get();

        return view('appointments.edit', compact('appointment', 'patients', 'staffMembers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $appointment = PatientAppointment::findOrFail($id);

        $validated = $request->validate([
            'patient_no' => 'required|exists:patient,patient_no',
            'staff_no' => 'required|exists:staff,staff_no',
            'clinic_number' => 'nullable|string|max:10',
            'date_of_appointment' => 'required|date',
            'time_of_appointment' => 'required|date_format:H:i',
            'examination_room' => 'required|string|max:20',
            'status' => 'required|string|in:Scheduled,Completed,Cancelled'
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = PatientAppointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }
}
