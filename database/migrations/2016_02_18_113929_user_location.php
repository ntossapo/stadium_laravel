<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_location', function(Blueprint $table){
            $table->increments("id");
            $table->string("facebook_id");
            $table->double("latitude");
            $table->double("longitude");
            $table->dateTime("last_used");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_location');
    }
}
