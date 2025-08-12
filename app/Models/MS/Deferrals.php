<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deferrals extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey = 'UniqueId';
    protected $table = 'Deferrals';
    protected $fillable = [
        'UniqueId'
        , 'DonorId'
        , 'OrgId'
        , 'DeferralTypeId'
        , 'TestResultId'
        , 'StartDate'
        , 'StopDate'
        , 'RevokeDate'
        , 'RevokeReason'
        , 'RevokedUserId'
        , 'RevokedOrgId'
        , 'CreateDate'
        , 'CreateUserId'
        , 'LastModifiedDate'
        , 'LastModifiedUserId'
        , 'Comments'
        , 'xDeferralTypeId'
        , 'DiseaseId'
        , 'EpidControlInactive'
    ];
    public $timestamps = false;

    const Fields = [
        ['ms' => 'UniqueId', 'aist' => 'deferrals_id'],
        ['ms' => 'DonorId', 'aist' => 'card_id'],
        ['ms' => 'OrgId', 'aist' => 'OrgId'],
        ['ms' => 'DeferralTypeId', 'aist' => 'DeferralTypeId', 'default' => 'const.Deferrals.DeferralTypeId'],
//        ['ms' => 'TestResultId', 'aist' => 'card_id'],
        ['ms' => 'StartDate', 'aist' => 'created_date'],
//        ['ms' => 'StopDate', 'aist' => 'card_id'],
//        ['ms' => 'RevokeDate', 'aist' => 'card_id'],
//        ['ms' => 'RevokeReason', 'aist' => 'card_id'],
//        ['ms' => 'RevokedUserId', 'aist' => 'card_id'],
//        ['ms' => 'RevokedOrgId', 'aist' => 'card_id'],
        ['ms' => 'CreateDate', 'aist' => 'created'],
        ['ms' => 'CreateUserId', 'aist' => 'card_id', 'default' => 'const.Deferrals.CreateUserId'],
//        ['ms' => 'LastModifiedDate', 'aist' => 'card_id'],
//        ['ms' => 'LastModifiedUserId', 'aist' => 'card_id'],
        ['ms' => 'Comments', 'aist' => 'comment'],
//        ['ms' => 'xDeferralTypeId', 'aist' => 'card_id'],
//        ['ms' => 'DiseaseId', 'aist' => 'card_id'],
        ['ms' => 'EpidControlInactive', 'aist' => 'card_id', 'default' => 'const.Deferrals.EpidControlInactive'],
    ];
    const ID = 'deferrals_id';
    const NAME = 'Deferrals';


}
