<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    protected $primaryKey = 'payment_no';
    public $timestamps = false;

    protected $fillable = [
        'payment_no',
        'bill_no',
        'amount',
        'payment_date',
        'method',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function bill()
    {
        return $this->belongsTo(PatientBill::class, 'bill_no', 'bill_no');
    }
}
