<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costs', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('area_id')->unsigned();
          $table->integer('vehicle_class_id')->unsigned();
          $table->integer('fuel')->unsigned()->default(0);
          $table->integer('cost1')->default(0)->comment('uang tarif');
          $table->integer('cost2')->default(0)->comment('uang do');
          $table->integer('cost3')->default(0)->comment('uang kuli');
          $table->integer('cost4')->default(0)->comment('uang tol');
          $table->integer('cost5')->default(0)->comment('uang lain');
          $table->integer('cost6')->default(0)->comment('uang laka');
          $table->integer('total_cost')->comment('uang laka');
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
        Schema::dropIfExists('costs');
    }
}
