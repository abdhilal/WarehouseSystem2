<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'area_id', 'warehouse_id', 'representative_id'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }







    public function files()
    {
        return $this->hasMany(File::class, 'representative_id');
    }
}
