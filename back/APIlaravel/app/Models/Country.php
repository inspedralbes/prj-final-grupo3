<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    // use HasFactory;

    // protected $table = "countries";

    public $timestamps = false;  // Si no estás usando los campos 'created_at' y 'updated_at'


    protected $fillable = [ "name", "code" ];


    public function travel(){
        return $this->hasOne(Travel::class);
    }
}
