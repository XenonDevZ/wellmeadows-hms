<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WellMeadowsSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('staff')->count() > 0) {
            return; // Data already exists
        }

        $now = Carbon::now();

        // 1. Staff Categories
        DB::table('staff_category')->insert([
            ['category_id' => 'C01', 'title' => 'Medical Director', 'description' => 'Head of Medical Staff', 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => 'C02', 'title' => 'Charge Nurse', 'description' => 'Head of a Ward', 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => 'C03', 'title' => 'Registered Nurse', 'description' => 'General Nursing duties', 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => 'C04', 'title' => 'Consultant', 'description' => 'Specialist Doctor', 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => 'C05', 'title' => 'Personnel Officer', 'description' => 'Human Resources', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 2. Staff
        DB::table('staff')->insert([
            [
                'staff_no' => 'S055', // Admin user's staff_no
                'first_name' => 'Admin',
                'last_name' => 'User',
                'address' => '123 Admin Way',
                'telephone_number' => '555-0000',
                'date_of_birth' => '1980-01-01',
                'sex' => 'M',
                'nin' => 'NIN0001',
                'position_category_id' => 'C01',
                'current_salary' => 120000.00,
                'salary_scale' => 'Scale 1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'staff_no' => 'S101',
                'first_name' => 'Moira',
                'last_name' => 'MacFarlane',
                'address' => '45 Nurse Rd',
                'telephone_number' => '555-1111',
                'date_of_birth' => '1975-05-15',
                'sex' => 'F',
                'nin' => 'NIN0002',
                'position_category_id' => 'C02',
                'current_salary' => 60000.00,
                'salary_scale' => 'Scale 3',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'staff_no' => 'S102',
                'first_name' => 'John',
                'last_name' => 'Smith',
                'address' => '12 Doctor Dr',
                'telephone_number' => '555-2222',
                'date_of_birth' => '1982-10-20',
                'sex' => 'M',
                'nin' => 'NIN0003',
                'position_category_id' => 'C04',
                'current_salary' => 90000.00,
                'salary_scale' => 'Scale 2',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // 3. Wards
        DB::table('ward')->insert([
            ['ward_no' => 'W11', 'ward_name' => 'Orthopaedic', 'location' => 'Block A', 'total_beds' => 10, 'telephone_extension' => '7711', 'charge_nurse_no' => 'S101', 'created_at' => $now, 'updated_at' => $now],
            ['ward_no' => 'W12', 'ward_name' => 'Pediatrics', 'location' => 'Block B', 'total_beds' => 15, 'telephone_extension' => '7712', 'charge_nurse_no' => 'S101', 'created_at' => $now, 'updated_at' => $now],
            ['ward_no' => 'W13', 'ward_name' => 'Cardiology', 'location' => 'Block C', 'total_beds' => 8, 'telephone_extension' => '7713', 'charge_nurse_no' => 'S101', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 4. Beds
        $beds = [];
        for ($i = 1; $i <= 5; $i++) {
            $beds[] = ['bed_no' => "W11-B0$i", 'ward_no' => 'W11', 'status' => 'Available', 'created_at' => $now, 'updated_at' => $now];
        }
        for ($i = 1; $i <= 5; $i++) {
            $beds[] = ['bed_no' => "W12-B0$i", 'ward_no' => 'W12', 'status' => 'Available', 'created_at' => $now, 'updated_at' => $now];
        }
        DB::table('bed')->insert($beds);

        // 5. Local Doctors
        DB::table('local_doctor')->insert([
            ['clinic_number' => 'C001', 'full_name' => 'Dr. Alexander Gray', 'address' => '101 Clinic St', 'telephone_number' => '555-8888', 'created_at' => $now, 'updated_at' => $now],
            ['clinic_number' => 'C002', 'full_name' => 'Dr. Susan Bones', 'address' => '202 Clinic Ave', 'telephone_number' => '555-9999', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 6. Patients
        DB::table('patient')->insert([
            [
                'patient_no' => 'P1001',
                'first_name' => 'Robert',
                'last_name' => 'Drumtree',
                'address' => '77 Maple Dr',
                'telephone_number' => '555-4444',
                'date_of_birth' => '1960-03-12',
                'sex' => 'M',
                'marital_status' => 'Married',
                'date_registered' => $now->subDays(10)->toDateString(),
                'next_of_kin_name' => 'Mary Drumtree',
                'next_of_kin_relationship' => 'Wife',
                'next_of_kin_address' => '77 Maple Dr',
                'next_of_kin_telephone' => '555-4444',
                'clinic_number' => 'C001',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'patient_no' => 'P1002',
                'first_name' => 'Alice',
                'last_name' => 'Green',
                'address' => '88 Oak Ln',
                'telephone_number' => '555-5555',
                'date_of_birth' => '1995-07-22',
                'sex' => 'F',
                'marital_status' => 'Single',
                'date_registered' => $now->subDays(5)->toDateString(),
                'next_of_kin_name' => 'Bob Green',
                'next_of_kin_relationship' => 'Father',
                'next_of_kin_address' => '88 Oak Ln',
                'next_of_kin_telephone' => '555-5555',
                'clinic_number' => 'C002',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // 7. Patient Appointments
        DB::table('patient_appointment')->insert([
            [
                'appointment_no' => 'A1001',
                'patient_no' => 'P1002',
                'staff_no' => 'S102',
                'clinic_number' => 'C002',
                'date_of_appointment' => $now->addDays(2)->toDateString(),
                'time_of_appointment' => '10:00:00',
                'examination_room' => 'Room 1A',
                'status' => 'Scheduled',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // 8. InPatients
        DB::table('in_patient')->insert([
            [
                'patient_no' => 'P1001',
                'ward_no' => 'W11',
                'bed_no' => 'W11-B01',
                'date_placed_on_waiting_list' => $now->subDays(10)->toDateString(),
                'expected_duration_of_stay' => '1 week',
                'date_placed_in_ward' => $now->subHours(2)->toDateString(),
                'date_expected_to_leave' => $now->addDays(7)->toDateString(),
                'actual_date_left' => null,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // Mark the bed as Occupied
        DB::table('bed')->where('bed_no', 'W11-B01')->update(['status' => 'Occupied']);

        // 9. Suppliers
        DB::table('supplier')->insert([
            ['supplier_no' => 'SUP01', 'name' => 'MedEquip Inc.', 'address' => '100 Supply Rd', 'telephone_number' => '555-7771', 'fax_number' => '555-7772', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_no' => 'SUP02', 'name' => 'PharmaCorp', 'address' => '200 Pharma Ave', 'telephone_number' => '555-7773', 'fax_number' => '555-7774', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 10. Items (Supplies)
        DB::table('item')->insert([
            ['item_no' => 'ITM01', 'name' => 'Surgical Masks', 'description' => 'N95 Medical Masks', 'quantity_in_stock' => 50, 'reorder_level' => 100, 'cost_per_unit' => 1.50, 'supplier_no' => 'SUP01', 'created_at' => $now, 'updated_at' => $now],
            ['item_no' => 'ITM02', 'name' => 'Paracetamol 500mg', 'description' => 'Pain relief tablets', 'quantity_in_stock' => 500, 'reorder_level' => 200, 'cost_per_unit' => 0.10, 'supplier_no' => 'SUP02', 'created_at' => $now, 'updated_at' => $now],
            ['item_no' => 'ITM03', 'name' => 'Latex Gloves', 'description' => 'Disposable medical gloves', 'quantity_in_stock' => 20, 'reorder_level' => 50, 'cost_per_unit' => 0.50, 'supplier_no' => 'SUP01', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
