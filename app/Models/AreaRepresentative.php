<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaRepresentative extends Model
{
    /** @use HasFactory<\Database\Factories\AreaRepresentativeFactory> */
    use HasFactory;

    protected $table = 'area_representative';


    protected $fillable = [
        'area_id',
        'representative_id',
    ];
}
