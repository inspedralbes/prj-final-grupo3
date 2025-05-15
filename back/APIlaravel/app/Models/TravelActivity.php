<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelActivity extends Model
{
  protected $fillable = [
    'travel_day_id',
    'name',
    'description',
    'price',
    'start_time',
    'end_time',
    'order'
  ];

  protected $casts = [
    'price' => 'decimal:2',
    'start_time' => 'datetime',
    'end_time' => 'datetime'
  ];

  public function travelDay()
  {
    return $this->belongsTo(TravelDay::class);
  }
}
