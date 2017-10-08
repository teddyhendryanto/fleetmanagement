<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerAddOnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_add_ons', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('counter')->unsigned();
          $table->string('customer_code');
          $table->string('customer_name');
          $table->string('rstatus',2)->default('NW');
          $table->string('created_by');
          $table->string('updated_by')->nullable();
          $table->string('deleted_by')->nullable();
          $table->timestamps();
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_add_ons');
    }
}
