<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMedication extends Model
{
    use HasFactory;

    protected $table = 'patient_medication';
    protected $primaryKey = 'prescription_id';
    public $timestamps = false;

    protected $fillable = [
        'patient_no',
        'medication_no',
        'units_per_day',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_no', 'patient_no');
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class, 'medication_no', 'medication_no');
    }
}
