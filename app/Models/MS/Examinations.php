<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examinations extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey = 'UniqueId';
    protected $table = 'Examinations';
    protected $fillable = [
        'UniqueId',
        'OrgId',
        'DonorId',
        'ExamType',
        'ExamDate',
        'ExamEndTime',
        'DeferralId',
        'CreateDate',
        'UserId',
        'HematologyResultType',
        'xUniqueId',
        'DoctorId',
        'OZKDoctorId'
    ];
    public $timestamps = false;

    const Fields = [
        ['ms' => 'UniqueId', 'aist' => 'examination_id'],//какой тут id число
        ['ms' => 'OrgId', 'aist' => 'OrgId'],
        ['ms' => 'DonorId', 'aist' => 'card_id'],
        ['ms' => 'ExamType', 'aist' => 'ExamType'],
        ['ms' => 'ExamDate', 'aist' => 'analysis_date'],
//        ['ms' => 'ExamEndTime', 'aist' => 'donation_org_id'],
//        ['ms' => 'DeferralId', 'aist' => 'donation_org_id'],
        ['ms' => 'CreateDate', 'aist' => 'LastModifiedDate'],
        ['ms' => 'UserId', 'aist' => 'donation_org_id', 'db_const' => 'user_id'],
        ['ms' => 'HematologyResultType', 'aist' => 'donation_org_id', 'default' => 'const.Examinations.HematologyResultType'],
//        ['ms' => 'xUniqueId', 'aist' => 'research_id'], //нету
//        ['ms' => 'DoctorId', 'aist' => 'donation_org_id'],
//        ['ms' => 'OZKDoctorId','aist' => 'donation_org_id'],

    ];
    const ID = 'examination_id';
    const NAME = 'Examinations';


}
