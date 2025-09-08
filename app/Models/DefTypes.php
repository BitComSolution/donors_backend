<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefTypes extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $fillable = [
        'aistCode',
        'eidbCode',
        'name'];
}
