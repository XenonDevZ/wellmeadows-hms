<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffQualification extends Model
{
    use HasFactory;

    protected $table = 'staff_qualification';
    protected $primaryKey = 'qualification_id';
    public $timestamps = false;

    protected $fillable = [
        'staff_no',
        'type',
        'date_earned',
        'institution_name',
    ];

    protected $casts = [
        'date_earned' => 'date',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_no', 'staff_no');
    }
}
