<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutPatient extends Model
{
    use HasFactory;

    protected $table = 'out_patient';
    protected $primaryKey = 'patient_no';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'patient_no',
        'appointment_no',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_no', 'patient_no');
    }

    public function appointment()
    {
        return $this->belongsTo(PatientAppointment::class, 'appointment_no', 'appointment_no');
    }
}
