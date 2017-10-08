<?php

namespace App\Models\Expedition;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleClass extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  public function costs(){
    return $this->hasMany('App\Models\Expedition\Cost');
  }

  public function vehicles(){
    return $this->hasMany('App\Models\Expedition\Vehicle');
  }
}
