<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Reserve extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserves', function(Blueprint $table){
            $table->increments("id");
            $table->string("facebook_id");
            $table->string("field_id");
            $table->date("date");
            $table->time("time_from");
            $table->time("time_to");
            $table->boolean("isConfirm");
            $table->boolean("isCheckIn");
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
        Schema::drop('reserves');
    }
}
