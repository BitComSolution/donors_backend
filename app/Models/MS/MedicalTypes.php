<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalTypes extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey = 'UniqueId';
    protected $table = 'ref.MedicalTestTypes';
    protected $fillable = [
        'Id'
        ,'Code'
        ,'ExamType'
        ,'Name'
        ,'ShortName'
        ,'BloodTestCategory'
        ,'Order'
        ,'ValueType'
        ,'MeasureUnit'
        ,'AgeGroupType'
        ,'IsQuarantineRequired'
        ,'IsVisible'
        ,'PrimaryTestId'
        ,'TestSystem'
        ,'Seriousness'
        ,'Color'
    ];
    public $timestamps = false;


}
