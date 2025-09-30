<?php

namespace App\Models\TWO;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodData extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'blooddata';
}
