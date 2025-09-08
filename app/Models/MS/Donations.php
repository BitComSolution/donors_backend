<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donations extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey = 'UniqueId';
    protected $table = 'Donations';
    protected $fillable = [
        'UniqueId',
        'DonorId',
        'OrgId',
        'DepartmentId',
        'DonationTypeId',
        'DonationDate',
        'Barcode',
        'Volume',
        'PublicationDate',
        'MobileTeamSessionId',
        'IsDeleted',
        'CreateDate',
        'CreateUserId',
        'LastModifiedDate',
        'LastModifiedUserId',
        'DataInputMethod',
        'ResultStatus'
    ];
    public $timestamps = false;

    const Fields = [
        ['ms' => 'UniqueId', 'aist' => 'donation_id'],
        ['ms' => 'DonorId', 'aist' => 'card_id'],
        ['ms' => 'OrgId', 'aist' => 'donation_org_128'],
        ['ms' => 'DepartmentId', 'aist' => 'donation_org_id', 'db_const' => 'DepartmentId'],
        ['ms' => 'DonationTypeId', 'aist' => 'donation_type_id'],
        ['ms' => 'DonationDate', 'aist' => 'donation_date'],
        ['ms' => 'Barcode', 'aist' => 'donation_barcode'],
        ['ms' => 'Volume', 'aist' => 'donation_volume'],
//        ['ms' => 'PublicationDate', 'aist' => 'research_date'],
//        ['ms' => 'MobileTeamSessionId', 'aist' => ''],
        ['ms' => 'IsDeleted', 'aist' => '', 'default' => 'const.Donations.IsDeleted'],
        ['ms' => 'CreateDate', 'aist' => 'created'],
        ['ms' => 'CreateUserId', 'aist' => 'author_id', 'db_const' => 'CreateUserId'],
        ['ms' => 'LastModifiedDate', 'aist' => 'LastModifiedDate'],
//        ['ms' => 'LastModifiedUserId', 'aist' => ''],
//        ['ms' => 'DataInputMethod', 'aist' => ''],
        ['ms' => 'ResultStatus', 'aist' => 'donation_analysis_result', 'default' => 'const.Donations.ResultStatus'],
    ];
    const ID = 'donation_id';
    const NAME = 'Donations';

}
