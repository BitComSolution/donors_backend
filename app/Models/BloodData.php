<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodData extends Model
{
    use HasFactory;

    protected $connection = 'db_two';
    protected $table = 'blooddata';
}
