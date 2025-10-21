<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Immunologies extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey = 'UniqueId';
    protected $table = 'Immunologies';
    protected $fillable = [
        'DonorId'
        , 'VersionCreateDate'
        , 'VersionCloseDate'
        , 'OrgId'
        , 'BloodGroup'
        , 'Rh'
        , 'Kell'
        , 'Phenotype'
        , 'RbcAntibody'
        , 'RbcAntibodyMethod'
        , 'Anti_A'
        , 'Anti_B'
        , 'Fy'
        , 'Le'
        , 'Kp'
        , 'Mn'
        , 'Ss'
        , 'Lu'
        , 'Jk'
        , 'Pi'
        , 'HLA'
        , 'SpecifiedParams'
        , 'UserId'
        , 'Chellano'
        , 'GrA'
        , 'GrB'
    ];
    public $timestamps = false;

    const Fields = [
        ['ms' => 'DonorId', 'aist' => 'card_id'],
        ['ms' => 'VersionCreateDate', 'aist' => 'donation_date'],// дата донации
        ['ms' => 'VersionCloseDate', 'aist' => 'donation_date'],
        ['ms' => 'OrgId', 'aist' => 'OrgIdTwo'],
        ['ms' => 'BloodGroup', 'aist' => 'blood_group'],
        ['ms' => 'Rh', 'aist' => 'rh_factor'],
        ['ms' => 'Kell', 'aist' => 'kell'],
        ['ms' => 'Phenotype', 'aist' => 'phenotype'],
        ['ms' => 'RbcAntibody', 'aist' => 'anti_erythrocyte_antibodies'],
//        ['ms' => 'RbcAntibodyMethod', 'aist' => 'examination_id'],
//        ['ms' => 'Anti_A', 'aist' => 'anti_a'],
//        ['ms' => 'Anti_B', 'aist' => 'anti_b'],
//        ['ms' => 'Fy', 'aist' => 'fy'],
//        ['ms' => 'Le', 'aist' => 'le'],
//        ['ms' => 'Kp', 'aist' => 'kp'],
//        ['ms' => 'Mn', 'aist' => 'mn'],
//        ['ms' => 'Ss', 'aist' => 'ss'],
//        ['ms' => 'Lu', 'aist' => 'lu'],
//        ['ms' => 'Jk', 'aist' => 'jk'],
//        ['ms' => 'Pi', 'aist' => 'pi'],
//        ['ms' => 'HLA', 'aist' => 'hla'],
        ['ms' => 'SpecifiedParams', 'aist' => 'examination_id','default' => 'const.Immunologies.SpecifiedParams'],
        ['ms' => 'UserId', 'aist' => 'donation_org_id', 'db_const' => 'user_id'],
//        ['ms' => 'Chellano', 'aist' => 'examination_id'],
//        ['ms' => 'GrA', 'aist' => 'gra'],
//        ['ms' => 'GrB', 'aist' => 'grb'],
    ];
    const ID = 'examination_id';
    const NAME = 'Immunologies';


}
