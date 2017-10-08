<?php

namespace App\Models\Expedition;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostSetting extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  public function cost(){
    return $this->belongsTo('App\Models\Expedition\Cost');
  }

}
