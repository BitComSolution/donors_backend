<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalTestResults extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey = 'UniqueId';
    protected $table = 'MedicalTestResults';
    protected $fillable = [
        'UniqueId',
        'ExaminationId',
        'TestTypeId',
        'TestValue',
        'IsNorm'
    ];
    public $timestamps = false;

    const Fields = [
//        ['ms' => 'UniqueId', 'aist' => 'medical_id'],
        ['ms' => 'ExaminationId', 'aist' => 'examination_id'],
        ['ms' => 'TestTypeId', 'aist' => 'test_type_id'],
        ['ms' => 'TestValue', 'aist' => 'test_value'],
        ['ms' => 'IsNorm', 'aist' => 'test_valid']

    ];
    const ID = 'medical_id';
    const NAME = 'MedicalTestResults';


}
