<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $table = 'ward';
    protected $primaryKey = 'ward_no';
    public $incrementing = false;
    protected $keyType = 'string';
    
    // Disable timestamps as we didn't include them in the schema for this specific table
    public $timestamps = false;

    protected $fillable = [
        'ward_no',
        'ward_name',
        'location',
        'total_beds',
        'telephone_extension',
        'charge_nurse_no',
    ];

    public function chargeNurse()
    {
        return $this->belongsTo(Staff::class, 'charge_nurse_no', 'staff_no');
    }

    public function beds()
    {
        return $this->hasMany(Bed::class, 'ward_no', 'ward_no');
    }

    public function getAvailableBedsCountAttribute()
    {
        return $this->beds()->where('status', 'Available')->count();
    }
}
