<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Place;

class Placetype extends Model
{
    public function places(){
        return $this->hasMany(Place::class);
    }
}
