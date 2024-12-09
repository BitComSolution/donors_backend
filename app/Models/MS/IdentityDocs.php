<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentityDocs extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey = 'UniqueId';
    protected $table = 'IdentityDocs';
    protected $fillable = [
        'UniqueId'
        , 'DocType'
        , 'Serie'
        , 'Number'
        , 'IssueDate'
        , 'IssuedBy'
        , 'IssuedByCode'];
    public $timestamps = false;

    const Fields = [
        ['ms' => 'DocType', 'aist' => 'document_type', 'default' => 'const.IdentityDocs.DocType'],
        ['ms' => 'Serie', 'aist' => 'document_serial'],
        ['ms' => 'Number', 'aist' => 'document_number'],
//        ['ms' => 'IssueDate', 'aist' => ' '],
//        ['ms' => 'IssuedBy', 'aist' => ' '],
//        ['ms' => 'IssuedByCode', 'aist' => ' '],
    ];
}
