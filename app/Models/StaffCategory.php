<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffCategory extends Model
{
    use HasFactory;

    protected $table = 'staff_category';
    protected $primaryKey = 'category_id';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
    ];

    public function staff()
    {
        return $this->hasMany(Staff::class, 'position_category_id', 'category_id');
    }
}
