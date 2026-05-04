<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $primaryKey = 'supplier_no';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'supplier_no',
        'name',
        'address',
        'telephone_number',
        'fax_number',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'supplier_no', 'supplier_no');
    }
}
