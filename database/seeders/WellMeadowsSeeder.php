<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WellMeadowsSeeder extends Seeder
{
    public function run(): void
    {
        // Clean existing fake data if it exists to avoid duplicate key errors
        if (DB::table('staff')->where('staff_no', 'S101')->exists() || DB::table('staff')->where('staff_no', 'S055')->exists()) {
            DB::table('in_patient')->delete();
            DB::table('patient_appointment')->delete();
            DB::table('patient')->delete();
            DB::table('local_doctor')->delete();
            DB::table('bed')->delete();
            DB::table('ward')->delete();
            DB::table('staff')->delete();
            DB::table('staff_category')->delete();
            DB::table('item')->delete();
            DB::table('medication')->delete();
        }

        if (DB::table('staff')->where('staff_no', 'S011')->exists()) {
            return; // Already seeded authentic data
        }

        $now = Carbon::now();

        // 1. Staff Categories
        DB::table('staff_category')->insert([
            ['category_id' => 'C01', 'title' => 'Medical Director', 'description' => 'Head of Medical Staff', 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => 'C02', 'title' => 'Charge Nurse', 'description' => 'Head of a Ward', 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => 'C03', 'title' => 'Staff Nurse', 'description' => 'General Nursing', 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => 'C04', 'title' => 'Consultant', 'description' => 'Specialist Doctor', 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => 'C05', 'title' => 'Nurse', 'description' => 'Junior Nursing Staff', 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => 'C06', 'title' => 'Administrator', 'description' => 'System Admin', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 2. Staff
        DB::table('staff')->insert([
            [
                'staff_no' => 'S055', // Admin user
                'first_name' => 'Admin',
                'last_name' => 'User',
                'address' => 'System',
                'telephone_number' => null,
                'date_of_birth' => null,
                'sex' => null,
                'nin' => null,
                'position_category_id' => 'C06',
                'current_salary' => null,
                'salary_scale' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'staff_no' => 'S011',
                'first_name' => 'Moira',
                'last_name' => 'Samuel',
                'address' => '49 School Road Broxburn',
                'telephone_number' => '01506-45633',
                'date_of_birth' => '1961-05-30',
                'sex' => 'Female',
                'nin' => 'WB123423D',
                'position_category_id' => 'C02', // Charge Nurse
                'current_salary' => 18760.00,
                'salary_scale' => '1C scale',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'staff_no' => 'S098',
                'first_name' => 'Carol',
                'last_name' => 'Cummings',
                'address' => '15 High Street Edinburgh',
                'telephone_number' => '0131-334-5677',
                'date_of_birth' => '1970-01-01',
                'sex' => 'Female',
                'nin' => 'NX111111A',
                'position_category_id' => 'C03', // Staff Nurse
                'current_salary' => 15000.00,
                'salary_scale' => '1D scale',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'staff_no' => 'S123',
                'first_name' => 'Morgan',
                'last_name' => 'Russell',
                'address' => '23A George Street Broxburn',
                'telephone_number' => '01506-67676',
                'date_of_birth' => '1975-02-02',
                'sex' => 'Male',
                'nin' => 'NX222222B',
                'position_category_id' => 'C05', // Nurse
                'current_salary' => 12000.00,
                'salary_scale' => '1E scale',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'staff_no' => 'S167',
                'first_name' => 'Robin',
                'last_name' => 'Plevin',
                'address' => '7 Glen Terrace Edinburgh',
                'telephone_number' => '0131-339-6123',
                'date_of_birth' => '1980-03-03',
                'sex' => 'Male',
                'nin' => 'NX333333C',
                'position_category_id' => 'C03', // Staff Nurse
                'current_salary' => 16000.00,
                'salary_scale' => '1D scale',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'staff_no' => 'S234',
                'first_name' => 'Amy',
                'last_name' => 'O\'Donnell',
                'address' => '234 Princes Street Edinburgh',
                'telephone_number' => '0131-334-9099',
                'date_of_birth' => '1985-04-04',
                'sex' => 'Female',
                'nin' => 'NX444444D',
                'position_category_id' => 'C05', // Nurse
                'current_salary' => 11000.00,
                'salary_scale' => '1E scale',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'staff_no' => 'S344',
                'first_name' => 'Laurence',
                'last_name' => 'Burns',
                'address' => '1 Apple Drive Edinburgh',
                'telephone_number' => '0131-344-9100',
                'date_of_birth' => '1965-05-05',
                'sex' => 'Male',
                'nin' => 'NX555555E',
                'position_category_id' => 'C04', // Consultant
                'current_salary' => 45000.00,
                'salary_scale' => '1A scale',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // 3. Wards
        DB::table('ward')->insert([
            ['ward_no' => 'Ward 11', 'ward_name' => 'Orthopaedic', 'location' => 'Block E', 'total_beds' => 240, 'telephone_extension' => '7711', 'charge_nurse_no' => 'S011', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 4. Beds (Case study lists bed numbers like 84, 79, 80, 87)
        DB::table('bed')->insert([
            ['bed_no' => '79', 'ward_no' => 'Ward 11', 'status' => 'Occupied', 'created_at' => $now, 'updated_at' => $now],
            ['bed_no' => '80', 'ward_no' => 'Ward 11', 'status' => 'Occupied', 'created_at' => $now, 'updated_at' => $now],
            ['bed_no' => '84', 'ward_no' => 'Ward 11', 'status' => 'Occupied', 'created_at' => $now, 'updated_at' => $now],
            ['bed_no' => '87', 'ward_no' => 'Ward 11', 'status' => 'Occupied', 'created_at' => $now, 'updated_at' => $now],
            ['bed_no' => '88', 'ward_no' => 'Ward 11', 'status' => 'Available', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 5. Local Doctors
        DB::table('local_doctor')->insert([
            ['clinic_number' => 'C001', 'full_name' => 'Dr. Helen Pearson', 'address' => '22 Cannongate Way, Edinburgh, EH1 6TY', 'telephone_number' => '0131-332-0012', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 6. Patients
        DB::table('patient')->insert([
            [
                'patient_no' => 'P10234',
                'first_name' => 'Anne',
                'last_name' => 'Phelps',
                'address' => '44 North Briges Cannonmills Edinburgh, EH1 5GH',
                'telephone_number' => '0131-332-4111',
                'date_of_birth' => '1933-12-12',
                'sex' => 'Female',
                'marital_status' => 'Single',
                'date_registered' => '1995-02-21',
                'next_of_kin_name' => 'James Phelps',
                'next_of_kin_relationship' => 'Father',
                'next_of_kin_address' => '145 Rowlands Street Paisley, PA2 5FE',
                'next_of_kin_telephone' => '0141-848-2211',
                'clinic_number' => 'C001',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'patient_no' => 'P10451',
                'first_name' => 'Robert',
                'last_name' => 'Drumtree', // Named Robber Drumtree in Fig 1.4
                'address' => 'Unknown',
                'telephone_number' => null,
                'date_of_birth' => null,
                'sex' => 'Male',
                'marital_status' => null,
                'date_registered' => '1996-01-12',
                'next_of_kin_name' => null,
                'next_of_kin_relationship' => null,
                'next_of_kin_address' => null,
                'next_of_kin_telephone' => null,
                'clinic_number' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'patient_no' => 'P10480',
                'first_name' => 'Steven',
                'last_name' => 'Parks',
                'address' => 'Unknown',
                'telephone_number' => null,
                'date_of_birth' => null,
                'sex' => 'Male',
                'marital_status' => null,
                'date_registered' => '1996-01-12',
                'next_of_kin_name' => null,
                'next_of_kin_relationship' => null,
                'next_of_kin_address' => null,
                'next_of_kin_telephone' => null,
                'clinic_number' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'patient_no' => 'P10563',
                'first_name' => 'David',
                'last_name' => 'Black',
                'address' => 'Unknown',
                'telephone_number' => null,
                'date_of_birth' => null,
                'sex' => 'Male',
                'marital_status' => null,
                'date_registered' => '1996-01-13',
                'next_of_kin_name' => null,
                'next_of_kin_relationship' => null,
                'next_of_kin_address' => null,
                'next_of_kin_telephone' => null,
                'clinic_number' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'patient_no' => 'P10604',
                'first_name' => 'Ian',
                'last_name' => 'Thompson',
                'address' => 'Unknown',
                'telephone_number' => null,
                'date_of_birth' => null,
                'sex' => 'Male',
                'marital_status' => null,
                'date_registered' => '1996-01-14',
                'next_of_kin_name' => null,
                'next_of_kin_relationship' => null,
                'next_of_kin_address' => null,
                'next_of_kin_telephone' => null,
                'clinic_number' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'patient_no' => 'P10034', // From figure 1.6 / 1.5
                'first_name' => 'Ronald',
                'last_name' => 'MacDonald',
                'address' => 'Unknown',
                'telephone_number' => null,
                'date_of_birth' => null,
                'sex' => 'Male',
                'marital_status' => null,
                'date_registered' => '1996-03-24',
                'next_of_kin_name' => null,
                'next_of_kin_relationship' => null,
                'next_of_kin_address' => null,
                'next_of_kin_telephone' => null,
                'clinic_number' => null,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // 7. Patient Appointments
        // No explicit appointment data in case study figures besides descriptions. We'll skip for now.

        // 8. InPatients
        DB::table('in_patient')->insert([
            [
                'patient_no' => 'P10451', // Robert Drumtree
                'ward_no' => 'Ward 11',
                'bed_no' => '84',
                'date_placed_on_waiting_list' => '1996-01-12',
                'expected_duration_of_stay' => '5',
                'date_placed_in_ward' => '1996-01-12',
                'date_expected_to_leave' => '1996-01-17',
                'actual_date_left' => '1996-01-27',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'patient_no' => 'P10480', // Steven Parks
                'ward_no' => 'Ward 11',
                'bed_no' => '79',
                'date_placed_on_waiting_list' => '1996-01-12',
                'expected_duration_of_stay' => '4',
                'date_placed_in_ward' => '1996-01-14',
                'date_expected_to_leave' => '1996-01-18',
                'actual_date_left' => '1996-01-25',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'patient_no' => 'P10563', // David Black
                'ward_no' => 'Ward 11',
                'bed_no' => '80',
                'date_placed_on_waiting_list' => '1996-01-13',
                'expected_duration_of_stay' => '14',
                'date_placed_in_ward' => '1996-01-13',
                'date_expected_to_leave' => null,
                'actual_date_left' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'patient_no' => 'P10604', // Ian Thompson
                'ward_no' => 'Ward 11',
                'bed_no' => '87',
                'date_placed_on_waiting_list' => '1996-01-14',
                'expected_duration_of_stay' => '10',
                'date_placed_in_ward' => '1996-01-15',
                'date_expected_to_leave' => null,
                'actual_date_left' => null,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // 9. Items / Drugs
        DB::table('item')->insert([
            ['item_no' => '10223', 'name' => 'Morphine', 'description' => 'Pain killer', 'quantity_in_stock' => 100, 'reorder_level' => 20, 'cost_per_unit' => 27.75, 'supplier_no' => null, 'created_at' => $now, 'updated_at' => $now],
            ['item_no' => '10334', 'name' => 'Tetracycline', 'description' => 'Antibiotic', 'quantity_in_stock' => 200, 'reorder_level' => 50, 'cost_per_unit' => 15.00, 'supplier_no' => null, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Drugs are also treated as medication
        DB::table('medication')->insert([
            ['medication_no' => '10223', 'name' => 'Morphine', 'description' => 'Pain killer', 'method_of_administration' => 'oral', 'dosage' => '10mg/ml', 'created_at' => $now, 'updated_at' => $now],
            ['medication_no' => '10334', 'name' => 'Tetracycline', 'description' => 'Antibiotic', 'method_of_administration' => 'IV', 'dosage' => '0.5mg/ml', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
