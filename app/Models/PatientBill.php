<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientBill extends Model
{
    use HasFactory;

    protected $table = 'patient_bill';
    protected $primaryKey = 'bill_no';
    public $timestamps = false;

    protected $fillable = [
        'bill_no',
        'patient_no',
        'total_amount',
        'bill_date',
        'status',
    ];

    protected $casts = [
        'bill_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_no', 'patient_no');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'bill_no', 'bill_no');
    }
}
