<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeferralTypes extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey = 'UniqueId';
    protected $table = 'ref.DeferralTypes';
    protected $fillable = [
        'UniqueId'
        ,'Code'
        ,'Name'
        ,'ShortName'
        ,'EtalonName'
        ,'BaseType'
        ,'IsEtalon'
        ,'UserId'
    ];
    public $timestamps = false;


}
