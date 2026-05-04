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
        if ($request->has('bill_search')) {
            $search = $request->bill_search;
            $billsQuery->whereHas('patient', function($q) use ($search) {
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
        $items = Item::orderBy('item_name')->paginate(15, ['*'], 'items_page');
        $suppliers = Supplier::orderBy('name')->get();

        return view('billing', compact('bills', 'requisitions', 'items', 'suppliers'));
    }
}
