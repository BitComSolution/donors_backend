<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $fillable = ['name', 'error', 'file'];

    const FIELD = [
        'card_id',
        'org_name',
        'name',
        'middlename',
        'gender',
        'birth_date',
        'donation_id',
        'donation_org_id',
        'donation_date',
        'validated'
    ];
}
