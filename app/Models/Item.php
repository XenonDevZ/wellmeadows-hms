<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'item';
    protected $primaryKey = 'item_number';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'item_number',
        'item_name',
        'description',
        'quantity_in_stock',
        'reorder_level',
        'cost_per_unit',
    ];

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'supplier_item', 'item_number', 'supplier_number');
    }
}
