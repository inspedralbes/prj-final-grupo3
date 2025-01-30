<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    protected $table = "travels";

    protected $fillable = [
        'id_country',
        'id_type',
        'id_budget',
        'id_movility',
        'qunt_date',
        'date_init',
        'date_end',
        'description',
    ];

    public function country(){
        return $this->hasOne(Country::class);
    }
}
