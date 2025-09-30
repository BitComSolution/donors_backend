<?php

namespace App\Models\TWO;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OsmotrData extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'osmotrdata';
}
