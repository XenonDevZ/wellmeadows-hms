<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patient';
    protected $primaryKey = 'patient_no';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'patient_no',
        'first_name',
        'last_name',
        'address',
        'telephone_number',
        'date_of_birth',
        'sex',
        'marital_status',
        'date_registered',
        'next_of_kin_name',
        'next_of_kin_relationship',
        'next_of_kin_address',
        'next_of_kin_telephone',
        'clinic_number',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_registered' => 'date',
    ];

    public function localDoctor()
    {
        return $this->belongsTo(LocalDoctor::class, 'clinic_number', 'clinic_number');
    }

    public function appointments()
    {
        return $this->hasMany(PatientAppointment::class, 'patient_no', 'patient_no');
    }

    public function admissions()
    {
        return $this->hasMany(InPatient::class, 'patient_no', 'patient_no');
    }

    public function currentAdmission()
    {
        return $this->hasOne(InPatient::class, 'patient_no', 'patient_no')->whereNull('actual_date_left')->latest('date_placed_on_waiting_list');
    }

    public function bills()
    {
        return $this->hasMany(PatientBill::class, 'patient_no', 'patient_no');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
