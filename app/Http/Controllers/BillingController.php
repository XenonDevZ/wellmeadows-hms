<?php

namespace App\Http\Controllers;

use App\Models\PatientBill;
use App\Models\WardRequisition;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    /**
     * Display the Billing & Requisition dashboard.
     */
    public function index(Request $request)
    {
        // Tab 1: Patient Billing
        $billsQuery = PatientBill::with('patient');
        if ($request->filled('bill_search')) {
            $search = $request->bill_search;
            $billsQuery->whereHas('patient', function ($q) use ($search) {
                $q->where('first_name', 'ilike', "%{$search}%")
                  ->orWhere('last_name', 'ilike', "%{$search}%");
            })->orWhere('bill_no', 'ilike', "%{$search}%");
        }
        $bills = $billsQuery->orderBy('bill_date', 'desc')->paginate(10, ['*'], 'bills_page');

        // Tab 2: Ward Requisitions
        $requisitions = WardRequisition::with(['ward', 'staff', 'items'])
                                       ->orderBy('date_ordered', 'desc')
                                       ->paginate(10, ['*'], 'req_page');

        // Tab 3: Suppliers & Stock
        $items = Item::orderBy('name')->paginate(15, ['*'], 'items_page');
        $suppliers = Supplier::orderBy('name')->get();

        return view('billing', compact('bills', 'requisitions', 'items', 'suppliers'));
    }

    // ─── Patient Billing Actions ──────────────────────────────────

    public function createBill()
    {
        $patients = \App\Models\Patient::orderBy('last_name')->get();
        return view('billing.create', compact('patients'));
    }

    public function storeBill(Request $request)
    {
        $request->validate([
            'patient_no'   => 'required|exists:patient,patient_no',
            'total_amount' => 'required|numeric|min:0',
            'bill_date'    => 'required|date',
            'status'       => 'required|in:Paid,Unpaid',
        ]);

        PatientBill::create([
            'patient_no'   => $request->patient_no,
            'total_amount' => $request->total_amount,
            'bill_date'    => $request->bill_date,
            'status'       => $request->status,
        ]);

        return redirect()->route('billing.index')->with('success', 'Patient bill created successfully.');
    }

    public function payBill($bill_no)
    {
        $bill = PatientBill::findOrFail($bill_no);
        $bill->status = 'Unpaid' === $bill->status ? 'Paid' : $bill->status;
        $bill->save();

        \App\Models\Payment::create([
            'bill_no'      => $bill->bill_no,
            'amount'       => $bill->total_amount,
            'payment_date' => now()->toDateString(),
            'method'       => 'Cash',
        ]);

        return redirect()->back()->with('success', 'Payment recorded. Bill is now Paid.');
    }

    // ─── Ward Requisition Actions ─────────────────────────────────

    public function createRequisition()
    {
        $wards       = \App\Models\Ward::orderBy('ward_name')->get();
        $staffMembers = \App\Models\Staff::orderBy('last_name')->get();
        $items       = Item::orderBy('name')->get();

        return view('requisitions.create', compact('wards', 'staffMembers', 'items'));
    }

    public function storeRequisition(Request $request)
    {
        $request->validate([
            'ward_no'      => 'required|exists:ward,ward_no',
            'staff_no'     => 'required|exists:staff,staff_no',
            'date_ordered' => 'required|date',
            'status'       => 'required|in:Pending,Approved,Delivered',
            'items'        => 'required|array|min:1',
            'items.*'      => 'exists:item,item_no',
        ]);

        $requisition = WardRequisition::create([
            'ward_no'      => $request->ward_no,
            'staff_no'     => $request->staff_no,
            'date_ordered' => $request->date_ordered,
            'status'       => $request->status,
        ]);

        // Attach chosen items with quantity = 1
        $attach = [];
        foreach ($request->items as $item_no) {
            $attach[$item_no] = ['quantity_required' => 1];
        }
        $requisition->items()->attach($attach);

        return redirect()->route('billing.index')->with('success', 'Ward requisition submitted successfully.');
    }

    public function approveRequisition($req_no)
    {
        $req = WardRequisition::findOrFail($req_no);
        $req->status = 'Approved';
        $req->save();

        return redirect()->back()->with('success', 'Requisition approved successfully.');
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'item_no'           => 'required|string|unique:item,item_no|max:20',
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'quantity_in_stock' => 'required|integer|min:0',
            'reorder_level'     => 'required|integer|min:0',
            'cost_per_unit'     => 'required|numeric|min:0',
            'supplier_no'       => 'nullable|exists:supplier,supplier_no',
        ]);

        Item::create($request->only([
            'item_no', 'name', 'description',
            'quantity_in_stock', 'reorder_level', 'cost_per_unit', 'supplier_no'
        ]));

        return redirect()->route('billing.index', ['#supplierTab'])->with('success', 'Item added to inventory successfully.');
    }
}
