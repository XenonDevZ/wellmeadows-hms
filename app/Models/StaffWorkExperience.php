<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffWorkExperience extends Model
{
    use HasFactory;

    protected $table = 'staff_work_experience';
    protected $primaryKey = 'experience_id';
    public $timestamps = false;

    protected $fillable = [
        'staff_no',
        'organization_name',
        'position',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_no', 'staff_no');
    }
}
