<?php

namespace App\Http\Controllers;

use App\Models\InPatient;
use App\Models\PatientBill;
use App\Models\PatientAppointment;
use App\Models\WardRequisition;
use App\Models\PatientMedication;
use App\Models\Ward;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'ward_patients'  => InPatient::whereNull('actual_date_left')->count(),
            'bills'          => PatientBill::count(),
            'appointments'   => PatientAppointment::count(),
            'requisitions'   => WardRequisition::count(),
            'medications'    => PatientMedication::count(),
        ];
        return view('reports', compact('stats'));
    }

    public function wardAllocation()
    {
        $wards = Ward::with(['inPatients.patient', 'chargeNurse'])->get();
        $totalAdmitted = InPatient::whereNull('actual_date_left')->count();
        $totalWaiting  = InPatient::whereNull('date_placed_in_ward')->count();
        return view('reports.ward_allocation', compact('wards', 'totalAdmitted', 'totalWaiting'));
    }

    public function billing()
    {
        $bills       = PatientBill::with('patient')->orderBy('bill_date', 'desc')->get();
        $totalAmount = $bills->sum('total_amount');
        $totalPaid   = $bills->where('status', 'Paid')->sum('total_amount');
        $totalUnpaid = $bills->where('status', 'Unpaid')->sum('total_amount');
        $paidCount   = $bills->where('status', 'Paid')->count();
        $unpaidCount = $bills->where('status', 'Unpaid')->count();
        return view('reports.billing', compact('bills', 'totalAmount', 'totalPaid', 'totalUnpaid', 'paidCount', 'unpaidCount'));
    }

    public function appointments()
    {
        $appointments   = PatientAppointment::with(['patient', 'staff'])->orderBy('date_of_appointment', 'desc')->get();
        $totalScheduled = $appointments->where('status', 'Scheduled')->count();
        $totalCompleted = $appointments->where('status', 'Completed')->count();
        $totalCancelled = $appointments->where('status', 'Cancelled')->count();
        return view('reports.appointments', compact('appointments', 'totalScheduled', 'totalCompleted', 'totalCancelled'));
    }

    public function requisitions()
    {
        $requisitions   = WardRequisition::with(['ward', 'staff', 'items'])->orderBy('date_ordered', 'desc')->get();
        $totalPending   = $requisitions->where('status', 'Pending')->count();
        $totalApproved  = $requisitions->where('status', 'Approved')->count();
        $totalDelivered = $requisitions->where('status', 'Delivered')->count();
        return view('reports.requisitions', compact('requisitions', 'totalPending', 'totalApproved', 'totalDelivered'));
    }

    public function medications()
    {
        $medications = PatientMedication::with(['patient', 'medication'])->get();
        return view('reports.medications', compact('medications'));
    }
}
