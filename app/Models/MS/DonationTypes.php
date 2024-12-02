<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationTypes extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey = 'UniqueId';
    protected $table = 'ref.DonationTypes';
    protected $fillable = [
        'UniqueId',
        'Code',
        'Name',
        'ShortName',
        'EtalonName',
        'ChargeType',
        'ComponentType',
        'DonationParams',
        'IsEtalon'
    ];
    public $timestamps = false;


}
