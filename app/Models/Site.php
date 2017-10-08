<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    public function vehicles(){
      return $this->hasMany('App\Models\Expedition\Vehicle');
    }
}
