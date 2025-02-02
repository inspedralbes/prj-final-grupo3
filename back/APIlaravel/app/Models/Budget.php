<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'min_price',
        'max_price',
        'final_price',
    ];

    public function travel(){
        return $this->hasOne(Travel::class);
    }
}
