<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheduled extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $fillable = ['title','last_start','period_hours','run'];
}
