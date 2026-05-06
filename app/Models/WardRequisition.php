<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WardRequisition extends Model
{
    use HasFactory;

    protected $table = 'ward_requisition';
    protected $primaryKey = 'requisition_no';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'ward_no',
        'staff_no',
        'date_ordered',
        'status',
    ];

    protected $casts = [
        'date_ordered' => 'date',
    ];

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_no', 'ward_no');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_no', 'staff_no');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'requisition_item', 'requisition_no', 'item_no')
                    ->withPivot('quantity_required');
    }
}
