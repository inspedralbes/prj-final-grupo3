<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movility extends Model
{
    use HasFactory;
    
    protected $table = 'movilities';
    protected $fillable = [ "type" ];
}
