<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtollCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etoll_cards', function (Blueprint $table) {
          $table->increments('id');
          $table->string('card_num');
          $table->integer('employee_id')->unsigned();
          $table->integer('vehicle_id')->unsigned();
          $table->string('rstatus',2)->default('NW');
          $table->string('created_by');
          $table->string('updated_by')->nullable();
          $table->string('deleted_by')->nullable();
          $table->timestamps();
          $table->softDeletes();

          // $table->foreign('employee_id')->references('id')->on('employees')
          //     ->onUpdate('cascade')->onDelete('cascade');
          // $table->foreign('vehicle_id')->references('id')->on('vehicles')
          //     ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etoll_cards');
    }
}
