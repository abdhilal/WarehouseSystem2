<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles,AuthorizesRequests;

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
