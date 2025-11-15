<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'warehouse_id'];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function pharmacies()
    {
        return $this->hasMany(Pharmacy::class);
    }

    public function representatives()
    {
        return $this->belongsToMany(Representative::class, 'area_representative');
    }

    public function salesReps()
    {
        return $this->representatives()->where('type', 'sales');
    }

    public function medicalReps()
    {
        return $this->representatives()->where('type', 'medical');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
