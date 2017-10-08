<?php

namespace App\Models\Expedition;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  /**
   * @return string date format for mssql
   */
  protected function getDateFormat()
  {
      return 'Y-m-d H:i:s.000';
  }

  public function site(){
    return $this->belongsTo('App\Models\Site','site_id','id');
  }

  public function vehicle_class(){
    return $this->belongsTo('App\Models\Expedition\VehicleClass','vehicle_class_id','id');
  }
}
