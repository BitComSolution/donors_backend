<?php

namespace App\Models\MS;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonCards extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey = 'UniqueId';
    protected $table = 'PersonCards';
    protected $fillable = [
        'UniqueId',
        'OrgId',
        'LastName',
        'FirstName',
        'MiddleName',
        'Gender',
        'BirthDate',
        'BirthDateIsUndefined',
        'RegDate',
        'IdentityDocId',
        'RegAddressId',
        'FactAddressId',
        'Phone',
        'PhoneMob',
        'Email',
        'JobInfo',
        'JobPosition',
        'NextDonationDate',
        'BloodGroup',
        'Kell',
        'Phenotype',
        'RbcAntibody',
        'DeathDate',
        'CreateDate',
        'CreateUserId',
        'LastModifiedDate',
        'LastModifiedUserId',
        'DonorBarcode',
        'Rh',
        'IsAgree',
        'AttachmentId',
        'Chellano',
        'IsDeleted',
        'FactAddressSinceDate',
        'GrA',
        'GrB',
        'RegAddressIsInactive',
        'FactAddressIsInactive',
        'IsMessageAgree',
        'IsActive',
        'TempAddressId',
        'TempAddressIsInactive',
        'TempAddressSinceDate',
        'SocialStatusId',
        'Snils',
        'BirthPlace',
        'DonationRefusal',
        'RegDateInactive',
        'FactDateInactive',
        'TempDateInactive',
        'HemStemCellsDonor',
        'InvitationSmsDate',
    ];
    public $timestamps = false;

    const Fields = [
        ['ms' => 'UniqueId', 'aist' => 'card_id'],
        ['ms' => 'OrgId', 'aist' => 'OrgId'],//test data
        ['ms' => 'LastName', 'aist' => 'lastname'],
        ['ms' => 'FirstName', 'aist' => 'name'],
        ['ms' => 'MiddleName', 'aist' => 'middlename'],
        ['ms' => 'Gender', 'aist' => 'gender'],
        ['ms' => 'BirthDate', 'aist' => 'birth_date'],
        ['ms' => 'BirthDateIsUndefined', 'aist' => '', 'default' => 'const.PersonCards.BirthDateIsUndefined'],
//        ['ms' => 'RegDate', 'aist' => ''],
        ['ms' => 'IdentityDocId', 'aist' => 'IdentityDocs'],
        ['ms' => 'RegAddressId', 'aist' => 'PersonAddresses'],//PersonAddresses id
//        ['ms' => 'FactAddressId', 'aist' => ''],
//        ['ms' => 'Phone', 'aist' => ''],
//        ['ms' => 'PhoneMob', 'aist' => ''],
//        ['ms' => 'Email', 'aist' => ''],
//        ['ms' => 'JobInfo', 'aist' => ''],
//        ['ms' => 'JobPosition', 'aist' => ''],
//        ['ms' => 'NextDonationDate', 'aist' => ''],
        ['ms' => 'BloodGroup', 'aist' => 'blood_group'],
        ['ms' => 'Kell', 'aist' => 'kell'],
        ['ms' => 'Phenotype', 'aist' => 'phenotype'],
//        ['ms' => 'RbcAntibody', 'aist' => 'anti_erythrocyte_antibodies'],
//        ['ms' => 'DeathDate', 'aist' => ''],
        ['ms' => 'CreateDate', 'aist' => 'created'],
        ['ms' => 'CreateUserId', 'aist' => 'author_id', 'default' => 'const.PersonCards.CreateUserId'],//test data
        ['ms' => 'LastModifiedDate', 'aist' => 'LastModifiedDate'],
//        ['ms' => 'LastModifiedUserId', 'aist' => ''],
//        ['ms' => 'DonorBarcode', 'aist' => 'donation_barcode'],
        ['ms' => 'Rh', 'aist' => 'rh_factor'],
        ['ms' => 'IsAgree', 'aist' => '', 'default' => 'const.PersonCards.IsAgree'],
//        ['ms' => 'AttachmentId', 'aist' => ''],
//        ['ms' => 'Chellano', 'aist' => ''],
        ['ms' => 'IsDeleted', 'aist' => '', 'default' => 'const.PersonCards.IsDeleted'],
//        ['ms' => 'FactAddressSinceDate', 'aist' => ''],
//        ['ms' => 'GrA', 'aist' => ''],
//        ['ms' => 'GrB', 'aist' => ''],
//        ['ms' => 'RegAddressIsInactive', 'aist' => ''],
//        ['ms' => 'FactAddressIsInactive', 'aist' => ''],
        ['ms' => 'IsMessageAgree', 'aist' => '', 'default' => 'const.PersonCards.IsMessageAgree'],
//        ['ms' => 'IsActive', 'aist' => ''],
//        ['ms' => 'TempAddressId', 'aist' => ''],
//        ['ms' => 'TempAddressIsInactive', 'aist' => ''],
//        ['ms' => 'TempAddressSinceDate', 'aist' => ''],
//        ['ms' => 'SocialStatusId', 'aist' => ''],
        ['ms' => 'Snils', 'aist' => 'snils'],
//        ['ms' => 'BirthPlace', 'aist' => ''],
//        ['ms' => 'DonationRefusal', 'aist' => ''],
//        ['ms' => 'RegDateInactive', 'aist' => ''],
//        ['ms' => 'FactDateInactive', 'aist' => ''],
//        ['ms' => 'TempDateInactive', 'aist' => ''],
        ['ms' => 'HemStemCellsDonor', 'aist' => '', 'default' => 'const.PersonCards.IsMessageAgree'],
//        ['ms' => 'InvitationSmsDate', 'aist' => ''],
    ];
    const ID = 'card_id';
    const NAME = 'PersonCards';

}
