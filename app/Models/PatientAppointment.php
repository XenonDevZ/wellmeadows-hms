<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientAppointment extends Model
{
    use HasFactory;

    protected $table = 'patient_appointment';
    protected $primaryKey = 'appointment_no';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'appointment_no',
        'patient_no',
        'staff_no',
        'clinic_number',
        'date_of_appointment',
        'time_of_appointment',
        'examination_room',
        'status',
    ];

    protected $casts = [
        'date_of_appointment' => 'date',
        'time_of_appointment' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_no', 'patient_no');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_no', 'staff_no');
    }
}
