<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodComponentMain extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'BloodComponentMain';
    protected $fillable = ['number', 'BloodNumber', 'BloodGroup', 'Phenotype', 'Count', 'Id', 'RegionReportGuid', 'OrgId', 'OrgName'];
    public $timestamps = false;
}
