<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'department_id',
        'url_aist',
        'host',
        'port',
        'database',
        'username',
        'password',
        'active',
        'vich',
        'hbs',
        'sif',
        'hcv',
        'pcr'];
}
