<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'factory_id', 'name', 'unit_price', 'warehouse_id'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}


