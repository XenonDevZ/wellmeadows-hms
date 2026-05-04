<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAllocation extends Model
{
    use HasFactory;

    protected $table = 'staff_allocation';
    protected $primaryKey = 'allocation_id';
    public $timestamps = false;

    protected $fillable = [
        'staff_no',
        'ward_no',
        'shift_no',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_no', 'staff_no');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_no', 'ward_no');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_no', 'shift_no');
    }
}
