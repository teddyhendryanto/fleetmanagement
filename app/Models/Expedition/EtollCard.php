<?php

namespace App\Models\Expedition;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EtollCard extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  public function employee(){
    return $this->belongsTo('App\Models\Expedition\Employee');
  }

  public function vehicle(){
    return $this->belongsTo('App\Models\Expedition\Vehicle');
  }
}
