<?php

namespace App\Models;

use App\Services\DataService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $guarded = [];

    protected $fillable = [
        'card_id',
        'lastname',
        'name',
        'middlename',
        'gender',
        'birth_date',
        'IdentityDocs',
        'address',
        'blood_group',
        'kell',
        'phenotype',
        'created',
        'LastModifiedDate',
        'rh_factor',
        'snils',
        'validated',
        'document_serial',
        'document_number',
        'document'
    ];

}
