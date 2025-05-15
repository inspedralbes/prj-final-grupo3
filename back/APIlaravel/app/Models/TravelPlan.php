<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TravelPlan extends Model
{
  protected $fillable = ['travel_id', 'title', 'summary_day', 'total_price'];

  public function travel()
  {
    return $this->belongsTo(Travel::class);
  }

  public function days()
  {
    return $this->hasMany(TravelDay::class);
  }
}