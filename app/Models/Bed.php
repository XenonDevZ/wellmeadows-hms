<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;

    protected $table = 'bed';
    protected $primaryKey = 'bed_no';
    public $incrementing = false;
    protected $keyType = 'string';
    
    // Disable timestamps
    public $timestamps = false;

    protected $fillable = [
        'bed_no',
        'ward_no',
        'status',
    ];

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_no', 'ward_no');
    }

    public function currentPatient()
    {
        return $this->hasOne(InPatient::class, 'bed_no', 'bed_no')->whereNull('actual_date_left')->latest('date_placed_in_ward');
    }
}
