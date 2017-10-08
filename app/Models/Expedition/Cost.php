<?php

namespace App\Models\Expedition;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cost extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  public function area(){
    return $this->belongsTo('App\Models\Expedition\Area','area_id','id')->orderBy('area');
  }

  public function cost_settings(){
    return $this->hasMany('App\Models\Expedition\CostSetting','cost_id','id');
  }

  public function vehicle_class(){
    return $this->belongsTo('App\Models\Expedition\VehicleClass');
  }
}
