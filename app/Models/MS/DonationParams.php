<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationParams extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey = 'UniqueId';
    protected $table = 'DonationParams';
    protected $fillable = [
        'DonationId'
        , 'TeamNum'
        , 'ConservantVolume'
        , 'ConsBloodVolume'
        , 'SerLabVol'
        , 'GemLabVol'
        , 'BakLabVol'
        , 'IsShortage'
        , 'IsOperDefect'
        , 'CreateDate'
        , 'UserId'
        , 'DoctorId'
        , 'PrimaryPlasmaVolume'
        , 'PlasmaSubstitutes'
        , 'StartDate'
        , 'StopDate'
        , 'DeviceType'
        , 'AnticoagulantRatio'
        , 'PlateletsInSolution'
    ];
    public $timestamps = false;

    const Fields = [

        ['ms' => 'DonationId', 'aist' => 'donation_id'],
//            ['ms' => 'TeamNum', 'aist' => 'donation_org_id', 'db_const' => 'department_id'],
        ['ms' => 'ConservantVolume', 'aist' => 'donation_org_id', 'default' => 'const.Donations.Default'],
        ['ms' => 'ConsBloodVolume', 'aist' => 'donation_org_id', 'default' => 'const.Donations.Default'],
        ['ms' => 'SerLabVol', 'aist' => 'donation_org_id', 'default' => 'const.Donations.Default'],
        ['ms' => 'GemLabVol', 'aist' => 'donation_org_id', 'default' => 'const.Donations.Default'],
        ['ms' => 'BakLabVol', 'aist' => 'donation_org_id', 'default' => 'const.Donations.Default'],
//            ['ms' => 'IsShortage', 'aist' => 'donation_org_id', 'db_const' => 'department_id'],
//            ['ms' => 'IsOperDefect', 'aist' => 'donation_org_id', 'db_const' => 'department_id'],
        ['ms' => 'CreateDate', 'aist' => 'created'],
        ['ms' => 'UserId', 'aist' => 'author_id', 'db_const' => 'user_id'],
//            ['ms' => 'DoctorId', 'aist' => 'donation_org_id', 'db_const' => 'department_id'],
//            ['ms' => 'PrimaryPlasmaVolume', 'aist' => 'donation_org_id', 'db_const' => 'department_id'],
//            ['ms' => 'PlasmaSubstitutes', 'aist' => 'donation_org_id', 'db_const' => 'department_id'],
//            ['ms' => 'StartDate', 'aist' => 'donation_org_id', 'db_const' => 'department_id'],
//            ['ms' => 'StopDate', 'aist' => 'donation_org_id', 'db_const' => 'department_id'],
//            ['ms' => 'DeviceType', 'aist' => 'donation_org_id', 'db_const' => 'department_id'],
//            ['ms' => 'AnticoagulantRatio', 'aist' => 'donation_org_id', 'db_const' => 'department_id'],
//            ['ms' => 'PlateletsInSolution', 'aist' => 'donation_org_id', 'db_const' => 'department_id'],

    ];
    const ID = 'donation_params_id';
    const NAME = 'DonationParams';

}
