<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelType extends Model
{
    use HasFactory;

    protected $table = 'type';
    protected $fillable = ["type"];
}
