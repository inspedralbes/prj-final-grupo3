<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budget';
    protected $fillable = [
        'min_budget',
        'max_budget',
        // 'final_price',
    ];

    public function travel(){
        return $this->hasOne(Travel::class);
    }
}
