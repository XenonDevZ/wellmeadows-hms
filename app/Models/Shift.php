<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shift';
    protected $primaryKey = 'shift_no';
    public $timestamps = false;

    protected $fillable = [
        'shift_type',
        'start_time',
        'end_time',
    ];

    public function staffAllocations()
    {
        return $this->hasMany(StaffAllocation::class, 'shift_no', 'shift_no');
    }
}
