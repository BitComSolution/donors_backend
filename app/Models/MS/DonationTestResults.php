<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationTestResults extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey = 'UniqueId';
    protected $table = 'DonationTestResults';
    protected $fillable = [
        'UniqueId'
        , 'DonationId'
        , 'TestTypeId'
        , 'IsDone'
        , 'TestValue'
        , 'MinValue'
        , 'MaxValue'
        , 'DeviationType'
        , 'CreateDate'
        , 'UserId'
    ];
    public $timestamps = false;

    const Fields = [
//        ['ms' => 'UniqueId', 'aist' => 'medical_id'],
        ['ms' => 'DonationId', 'aist' => 'donation_id'],
        ['ms' => 'TestTypeId', 'aist' => 'test_type_id'],
        ['ms' => 'IsDone', 'aist' => 'donation_id', 'default' => 'const.Donations.IsDeleted'],
        ['ms' => 'TestValue', 'aist' => 'test_value'],
//         ['ms' => 'MinValue', 'aist' => 'donation_id'],
//         ['ms' => 'MaxValue', 'aist' => 'donation_id'],
        ['ms' => 'DeviationType', 'aist' => 'donation_id', 'default' => 'const.Donations.IsDeleted'],
        ['ms' => 'CreateDate', 'aist' => 'created'],
        ['ms' => 'UserId', 'aist' => 'donation_user'],

    ];
    const ID = 'medical_id';
    const NAME = 'MedicalTestResults';


}
