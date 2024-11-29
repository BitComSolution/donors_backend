<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizations extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'ref.Organizations';
    protected $fillable = [
        'UniqueId'
        ,'GlKey'
        ,'GlBlocks'
        ,'OrgCode'
        ,'Code'
        ,'Name'
        ,'ShortName'
        ,'ParentId'
        ,'RegionId'
        ,'Address'
        ,'HeadFullName'
        ,'PhonePrefix'
        ,'Phone'
        ,'EgiszId'
        ,'LabPhone'
        ,'EtalonName'
        ,'IsActive'
    ];
    public $timestamps = false;


}
