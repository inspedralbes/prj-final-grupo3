<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelDay extends Model
{
  protected $fillable = ['travel_plan_id', 'date', 'accommodation', 'day_number'];

  protected $casts = [
    'date' => 'date'
  ];

  public function travelPlan()
  {
    return $this->belongsTo(TravelPlan::class);
  }

  public function activities()
  {
    return $this->hasMany(TravelActivity::class);
  }
}
