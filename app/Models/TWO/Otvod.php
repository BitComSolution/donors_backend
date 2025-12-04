<?php

namespace App\Models\TWO;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otvod extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'otvoddata';

    public function latestByCard()
    {
        return $this->hasOne(Otvod::class, 'card_id', 'card_id')
            ->latestOfMany('ex_created');
    }
}
