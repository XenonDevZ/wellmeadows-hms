<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $table = 'medication';
    protected $primaryKey = 'medication_no';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'medication_no',
        'name',
        'description',
        'method_of_administration',
        'dosage',
    ];

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_medication', 'medication_no', 'patient_no')
                    ->withPivot('units_per_day', 'start_date', 'end_date');
    }
}
