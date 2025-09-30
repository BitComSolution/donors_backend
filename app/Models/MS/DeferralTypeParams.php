<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeferralTypeParams extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey = 'DeferralTypeId';
    protected $table = 'ref.DeferralTypes';
    protected $fillable = ['DeferralTypeId'
        , 'TempDeferralPeriod'
        , 'EpidControlPeriod'
        , 'CausesDefectTypeId'
        , 'DiseaseTypeId'
        , 'DiseaseGroup'
        , 'Priority'
        , 'VisibleForDoctor'
        , 'AffectsExpedition'
        , 'IsActive'
        , 'EpidControlDeathPeriod'
        , 'UserId'];
    public $timestamps = false;


}
