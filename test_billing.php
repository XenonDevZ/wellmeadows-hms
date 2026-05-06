<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Checking Patient columns...\n";
    echo "First patient: " . \App\Models\Patient::first()->last_name . "\n";
} catch (\Exception $e) { echo "Error: " . $e->getMessage() . "\n"; }

try {
    echo "Checking Ward columns...\n";
    echo "First ward: " . \App\Models\Ward::first()->ward_name . "\n";
} catch (\Exception $e) { echo "Error: " . $e->getMessage() . "\n"; }

try {
    echo "Checking Item columns...\n";
    echo "First item: " . \App\Models\Item::first()->item_name . "\n";
} catch (\Exception $e) { echo "Error: " . $e->getMessage() . "\n"; }

try {
    echo "Testing Create Bill...\n";
    $bill = \App\Models\PatientBill::create([
        'bill_no' => 'BTEST01',
        'patient_no' => \App\Models\Patient::first()->patient_no,
        'total_amount' => 100.50,
        'bill_date' => date('Y-m-d'),
        'status' => 'Unpaid'
    ]);
    echo "Bill created!\n";
} catch (\Exception $e) { echo "Error: " . $e->getMessage() . "\n"; }

try {
    echo "Testing Record Payment...\n";
    $bill = \App\Models\PatientBill::where('bill_no', 'BTEST01')->first();
    $bill->status = 'Paid';
    $bill->save();
    \App\Models\Payment::create([
        'payment_no' => 'PTEST01',
        'bill_no' => $bill->bill_no,
        'amount' => $bill->total_amount,
        'payment_date' => date('Y-m-d'),
        'method' => 'Credit Card',
    ]);
    echo "Payment recorded!\n";
} catch (\Exception $e) { echo "Error: " . $e->getMessage() . "\n"; }

try {
    echo "Testing Create Requisition...\n";
    $req = \App\Models\WardRequisition::create([
        'requisition_no' => 'RTEST01',
        'ward_no' => \App\Models\Ward::first()->ward_no,
        'staff_no' => \App\Models\Staff::first()->staff_no,
        'date_ordered' => date('Y-m-d'),
        'status' => 'Pending'
    ]);
    $req->items()->attach([\App\Models\Item::first()->item_number => ['quantity_required' => 1]]);
    echo "Requisition created!\n";
} catch (\Exception $e) { echo "Error: " . $e->getMessage() . "\n"; }

