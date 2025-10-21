<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Org extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $fillable = ['name',
        'code',
        'start',
        'end',
        'block'];
}

