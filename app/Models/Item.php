<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'item';
    protected $primaryKey = 'item_no';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'item_no',
        'name',
        'description',
        'quantity_in_stock',
        'reorder_level',
        'cost_per_unit',
        'supplier_no',
    ];

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_no', 'supplier_no');
    }

    public function requisitions()
    {
        return $this->belongsToMany(WardRequisition::class, 'requisition_item', 'item_no', 'requisition_no')
                    ->withPivot('quantity_required');
    }
}
