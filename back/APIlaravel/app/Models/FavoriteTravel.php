<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteTravel extends Model
{
    protected $table = 'favorite_travel';
    protected $fillable = [
        'user_id',
        'travel_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function travel()
    {
        return $this->belongsTo(Travel::class);
    }
}
