<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use App\Models\Country;

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

    public function country()
    {
        return $this->belongsTo(Country::class, 'id_country');
    }

    public function type()
    {
        return $this->belongsTo(TravelType::class, 'id_type');
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'id_budget');
    }

    public function movility()
    {
        return $this->belongsTo(Movility::class, 'id_movility');
    }
}
