<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';
    protected $primaryKey = 'staff_no';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'staff_no',
        'first_name',
        'last_name',
        'address',
        'telephone_number',
        'date_of_birth',
        'sex',
        'nin',
        'position_category_id',
        'current_salary',
        'salary_scale',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'current_salary' => 'decimal:2',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'staff_no', 'staff_no');
    }

    public function category()
    {
        return $this->belongsTo(StaffCategory::class, 'position_category_id', 'category_id');
    }

    public function qualifications()
    {
        return $this->hasMany(StaffQualification::class, 'staff_no', 'staff_no');
    }

    public function workExperiences()
    {
        return $this->hasMany(StaffWorkExperience::class, 'staff_no', 'staff_no');
    }

    public function managedWards()
    {
        return $this->hasMany(Ward::class, 'charge_nurse_no', 'staff_no');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
