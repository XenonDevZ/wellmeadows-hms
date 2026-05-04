<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InPatient extends Model
{
    use HasFactory;

    protected $table = 'in_patient';
    protected $primaryKey = 'patient_no';
    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'patient_no',
        'ward_no',
        'bed_no',
        'date_placed_on_waiting_list',
        'expected_duration_of_stay',
        'date_placed_in_ward',
        'date_expected_to_leave',
        'actual_date_left',
    ];

    protected $casts = [
        'date_placed_on_waiting_list' => 'date',
        'date_placed_in_ward' => 'date',
        'date_expected_to_leave' => 'date',
        'actual_date_left' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_no', 'patient_no');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_no', 'ward_no');
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class, 'bed_no', 'bed_no');
    }
}
