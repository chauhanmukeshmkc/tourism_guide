<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Place;

class Placetype extends Model
{
    public function places(){
        return $this->hasMany(Place::class);
    }
}
