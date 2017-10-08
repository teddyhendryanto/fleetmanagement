<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_settings', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('vehicle_class_id')->unsigned();
          $table->integer('cost_id')->unsigned();
          $table->string('customer_code');
          $table->boolean('cost1')->default(false)->comment('uang tarif');
          $table->boolean('cost2')->default(false)->comment('uang do');
          $table->boolean('cost3')->default(false)->comment('uang kuli');
          $table->boolean('cost4')->default(false)->comment('uang tol');
          $table->boolean('cost5')->default(false)->comment('uang lain');
          $table->boolean('cost6')->default(false)->comment('uang laka');
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
        Schema::dropIfExists('cost_settings');
    }
}
