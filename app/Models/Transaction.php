<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'pharmacy_id',
        'quantity_product',
        'product_id',
        'quantity_gift',
        'value_income',
        'value_output',
        'representative_id',
        'area_id',
        'value_gift',


        'warehouse_id',
        'file_id',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }



    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function representative()
    {
        return $this->belongsTo(Representative::class, 'representative_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }


}
