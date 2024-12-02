<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonAddresses extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey = 'UniqueId';
    protected $table = 'PersonAddresses';
    protected $fillable = [
        'UniqueId',
        'House',
        'Building',
        'Struct',
        'Flat',
        'PostalCode',
        'PlaneAddress',
        'FiasAddrObjGuid'
    ];

    public $timestamps = false;

    const Fields = [
        ['ms' => 'PlaneAddress', 'aist' => 'address'],
    ];
}
