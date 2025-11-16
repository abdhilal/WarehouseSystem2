<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    /** @use HasFactory<\Database\Factories\RepresentativeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'warehouse_id',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
    public function pharmacies()
    {
        return $this->hasMany(Pharmacy::class);
    }
    public function areas()
    {
        return $this->belongsToMany(Area::class, 'area_representative');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
