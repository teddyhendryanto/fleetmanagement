<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Expedition\CustomerAddOn;

use DB;

class Customer extends Model
{
  protected $table = 'STAGINGCPS.dbo.CUSTOMER';

  public function scopeCustomer_union_addon($query){
    $customers = $query->select(['CUSTOMER.CODE as customer_code','CUSTOMER.NAME as customer_name']);
    $add_ons = DB::table('customer_add_ons')
                  ->select(['customer_code','customer_name'])
                  ->union($customers)
                  ->orderBy('customer_name')
                  ->get();

    return $add_ons;
  }
}
