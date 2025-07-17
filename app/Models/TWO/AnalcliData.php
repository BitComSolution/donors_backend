<?php

namespace App\Models\TWO;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalcliData extends Model
{
    use HasFactory;

    protected $connection = 'db_two';
    protected $table = 'analclidata';
}
