<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Country;

class Travel extends Model
{
    protected $table = "travels";
    protected $fillable = [
        'id_user',
        'id_country',
        'id_type',
        'id_budget',
        'id_movility',
        'date_init',
        'date_end',
        'qunt_date',
        'description',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($travel) {
            // Calculamos la diferencia en días entre date_init y date_end
            $start = Carbon::parse($travel->date_init);
            $end = Carbon::parse($travel->date_end);

            // Asignamos la cantidad de días
            $travel->qunt_date = $start->diffInDays($end);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

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
