<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\LocalDoctor;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the patients.
     */
    public function index()
    {
        $patients = Patient::with(['currentAdmission.ward', 'appointments'])->latest('date_registered')->paginate(10);
        
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new patient.
     */
    public function create()
    {
        $doctors = LocalDoctor::all();
        return view('patients.create', compact('doctors'));
    }

    /**
     * Store a newly created patient in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_no' => 'required|string|unique:patient,patient_no',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'address' => 'required|string',
            'telephone_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:M,F',
            'marital_status' => 'required|in:Single,Married,Divorced,Widowed',
            'date_registered' => 'required|date',
            'next_of_kin_name' => 'required|string|max:100',
            'next_of_kin_relationship' => 'required|string|max:50',
            'next_of_kin_address' => 'required|string',
            'next_of_kin_telephone' => 'required|string|max:20',
            'clinic_number' => 'nullable|exists:local_doctor,clinic_number',
        ]);

        Patient::create($validated);

        return redirect()->route('patients.index')->with('success', 'Patient registered successfully.');
    }

    /**
     * Display the specified patient profile.
     */
    public function show($id)
    {
        $patient = Patient::with(['currentAdmission.ward', 'currentAdmission.bed', 'appointments', 'bills'])->findOrFail($id);
        
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified patient.
     */
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        $doctors = LocalDoctor::all();
        
        return view('patients.edit', compact('patient', 'doctors'));
    }

    /**
     * Update the specified patient in storage.
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'address' => 'required|string',
            'telephone_number' => 'required|string|max:20',
            'marital_status' => 'required|in:Single,Married,Divorced,Widowed',
            'next_of_kin_name' => 'required|string|max:100',
            'next_of_kin_relationship' => 'required|string|max:50',
            'next_of_kin_address' => 'required|string',
            'next_of_kin_telephone' => 'required|string|max:20',
            'clinic_number' => 'nullable|exists:local_doctor,clinic_number',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.show', $patient->patient_no)->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified patient from storage.
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient record deleted.');
    }
}
