<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        if (!Schema::hasTable('staff_category')) {
            Schema::create('staff_category', function (Blueprint $table) {
                $table->string('category_id')->primary();
                $table->string('title');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('staff')) {
            Schema::create('staff', function (Blueprint $table) {
                $table->string('staff_no')->primary();
                $table->string('first_name');
                $table->string('last_name');
                $table->text('address')->nullable();
                $table->string('telephone_number')->nullable();
                $table->date('date_of_birth')->nullable();
                $table->string('sex')->nullable();
                $table->string('nin')->nullable();
                $table->string('position_category_id')->nullable();
                $table->decimal('current_salary', 10, 2)->nullable();
                $table->string('salary_scale')->nullable();
                $table->timestamps();

                $table->foreign('position_category_id')->references('category_id')->on('staff_category')->nullOnDelete();
            });
        }

        if (!Schema::hasTable('ward')) {
            Schema::create('ward', function (Blueprint $table) {
                $table->string('ward_no')->primary();
                $table->string('ward_name');
                $table->string('location')->nullable();
                $table->integer('total_beds')->default(0);
                $table->string('telephone_extension')->nullable();
                $table->string('charge_nurse_no')->nullable();
                $table->timestamps();

                $table->foreign('charge_nurse_no')->references('staff_no')->on('staff')->nullOnDelete();
            });
        }

        if (!Schema::hasTable('bed')) {
            Schema::create('bed', function (Blueprint $table) {
                $table->string('bed_no')->primary();
                $table->string('ward_no');
                $table->string('status')->default('Available');
                $table->timestamps();

                $table->foreign('ward_no')->references('ward_no')->on('ward')->cascadeOnDelete();
            });
        }

        if (!Schema::hasTable('supplier')) {
            Schema::create('supplier', function (Blueprint $table) {
                $table->string('supplier_no')->primary();
                $table->string('name');
                $table->text('address')->nullable();
                $table->string('telephone_number')->nullable();
                $table->string('fax_number')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('item')) {
            Schema::create('item', function (Blueprint $table) {
                $table->string('item_no')->primary();
                $table->string('name');
                $table->text('description')->nullable();
                $table->integer('quantity_in_stock')->default(0);
                $table->integer('reorder_level')->default(0);
                $table->decimal('cost_per_unit', 10, 2)->default(0);
                $table->string('supplier_no')->nullable();
                $table->timestamps();

                $table->foreign('supplier_no')->references('supplier_no')->on('supplier')->nullOnDelete();
            });
        }

        if (!Schema::hasTable('local_doctor')) {
            Schema::create('local_doctor', function (Blueprint $table) {
                $table->string('clinic_number')->primary();
                $table->string('full_name');
                $table->text('address')->nullable();
                $table->string('telephone_number')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('patient')) {
            Schema::create('patient', function (Blueprint $table) {
                $table->string('patient_no')->primary();
                $table->string('first_name');
                $table->string('last_name');
                $table->text('address')->nullable();
                $table->string('telephone_number')->nullable();
                $table->date('date_of_birth')->nullable();
                $table->string('sex')->nullable();
                $table->string('marital_status')->nullable();
                $table->date('date_registered')->nullable();
                $table->string('next_of_kin_name')->nullable();
                $table->string('next_of_kin_relationship')->nullable();
                $table->text('next_of_kin_address')->nullable();
                $table->string('next_of_kin_telephone')->nullable();
                $table->string('clinic_number')->nullable();
                $table->timestamps();

                $table->foreign('clinic_number')->references('clinic_number')->on('local_doctor')->nullOnDelete();
            });
        }

        if (!Schema::hasTable('patient_appointment')) {
            Schema::create('patient_appointment', function (Blueprint $table) {
                $table->string('appointment_no')->primary();
                $table->string('patient_no')->nullable();
                $table->string('staff_no')->nullable();
                $table->string('clinic_number')->nullable();
                $table->date('date_of_appointment')->nullable();
                $table->time('time_of_appointment')->nullable();
                $table->string('examination_room')->nullable();
                $table->string('status')->default('Scheduled');
                $table->timestamps();

                $table->foreign('patient_no')->references('patient_no')->on('patient')->cascadeOnDelete();
                $table->foreign('staff_no')->references('staff_no')->on('staff')->nullOnDelete();
                $table->foreign('clinic_number')->references('clinic_number')->on('local_doctor')->nullOnDelete();
            });
        }

        if (!Schema::hasTable('in_patient')) {
            Schema::create('in_patient', function (Blueprint $table) {
                $table->string('patient_no')->primary();
                $table->string('ward_no')->nullable();
                $table->string('bed_no')->nullable();
                $table->date('date_placed_on_waiting_list')->nullable();
                $table->string('expected_duration_of_stay')->nullable();
                $table->date('date_placed_in_ward')->nullable();
                $table->date('date_expected_to_leave')->nullable();
                $table->date('actual_date_left')->nullable();
                $table->timestamps();

                $table->foreign('patient_no')->references('patient_no')->on('patient')->cascadeOnDelete();
                $table->foreign('ward_no')->references('ward_no')->on('ward')->nullOnDelete();
                $table->foreign('bed_no')->references('bed_no')->on('bed')->nullOnDelete();
            });
        }

        if (!Schema::hasTable('out_patient')) {
            Schema::create('out_patient', function (Blueprint $table) {
                $table->string('patient_no')->primary();
                $table->string('appointment_no')->nullable();
                $table->timestamps();

                $table->foreign('patient_no')->references('patient_no')->on('patient')->cascadeOnDelete();
                $table->foreign('appointment_no')->references('appointment_no')->on('patient_appointment')->nullOnDelete();
            });
        }

        if (!Schema::hasTable('medication')) {
            Schema::create('medication', function (Blueprint $table) {
                $table->string('medication_no')->primary();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('method_of_administration')->nullable();
                $table->string('dosage')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('patient_medication')) {
            Schema::create('patient_medication', function (Blueprint $table) {
                $table->id('prescription_id');
                $table->string('patient_no');
                $table->string('medication_no');
                $table->string('units_per_day')->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->timestamps();

                $table->foreign('patient_no')->references('patient_no')->on('patient')->cascadeOnDelete();
                $table->foreign('medication_no')->references('medication_no')->on('medication')->cascadeOnDelete();
            });
        }

        if (!Schema::hasTable('shift')) {
            Schema::create('shift', function (Blueprint $table) {
                $table->string('shift_no')->primary();
                $table->string('shift_type')->nullable();
                $table->time('start_time')->nullable();
                $table->time('end_time')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('staff_allocation')) {
            Schema::create('staff_allocation', function (Blueprint $table) {
                $table->id('allocation_id');
                $table->string('staff_no');
                $table->string('ward_no');
                $table->string('shift_no');
                $table->date('date')->nullable();
                $table->timestamps();

                $table->foreign('staff_no')->references('staff_no')->on('staff')->cascadeOnDelete();
                $table->foreign('ward_no')->references('ward_no')->on('ward')->cascadeOnDelete();
                $table->foreign('shift_no')->references('shift_no')->on('shift')->cascadeOnDelete();
            });
        }

        if (!Schema::hasTable('staff_qualification')) {
            Schema::create('staff_qualification', function (Blueprint $table) {
                $table->id('qualification_id');
                $table->string('staff_no');
                $table->string('type');
                $table->date('date_earned')->nullable();
                $table->string('institution_name')->nullable();
                $table->timestamps();

                $table->foreign('staff_no')->references('staff_no')->on('staff')->cascadeOnDelete();
            });
        }

        if (!Schema::hasTable('staff_work_experience')) {
            Schema::create('staff_work_experience', function (Blueprint $table) {
                $table->id('experience_id');
                $table->string('staff_no');
                $table->string('organization_name');
                $table->string('position')->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->timestamps();

                $table->foreign('staff_no')->references('staff_no')->on('staff')->cascadeOnDelete();
            });
        }

        if (!Schema::hasTable('ward_requisition')) {
            Schema::create('ward_requisition', function (Blueprint $table) {
                $table->string('requisition_no')->primary();
                $table->string('ward_no');
                $table->string('staff_no');
                $table->date('date_ordered')->nullable();
                $table->string('status')->default('Pending');
                $table->timestamps();

                $table->foreign('ward_no')->references('ward_no')->on('ward')->cascadeOnDelete();
                $table->foreign('staff_no')->references('staff_no')->on('staff')->cascadeOnDelete();
            });
        }

        if (!Schema::hasTable('patient_bill')) {
            Schema::create('patient_bill', function (Blueprint $table) {
                $table->string('bill_no')->primary();
                $table->string('patient_no');
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->date('bill_date')->nullable();
                $table->string('status')->default('Unpaid');
                $table->timestamps();

                $table->foreign('patient_no')->references('patient_no')->on('patient')->cascadeOnDelete();
            });
        }

        if (!Schema::hasTable('payment')) {
            Schema::create('payment', function (Blueprint $table) {
                $table->string('payment_no')->primary();
                $table->string('bill_no');
                $table->decimal('amount', 10, 2);
                $table->date('payment_date')->nullable();
                $table->string('method')->nullable();
                $table->timestamps();

                $table->foreign('bill_no')->references('bill_no')->on('patient_bill')->cascadeOnDelete();
            });
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        $tables = [
            'payment', 'patient_bill', 'ward_requisition', 'staff_work_experience',
            'staff_qualification', 'staff_allocation', 'shift', 'patient_medication',
            'medication', 'out_patient', 'in_patient', 'patient_appointment',
            'patient', 'local_doctor', 'item', 'supplier', 'bed', 'ward',
            'staff', 'staff_category'
        ];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
        Schema::enableForeignKeyConstraints();
    }
};
