<?php

namespace App\Models\Expedition;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerAddOn extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];
}
