<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /** @use HasFactory<\Database\Factories\FileFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'month',
        'path',
        'year',
        'warehouse_id',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'file_id');
    }


}
