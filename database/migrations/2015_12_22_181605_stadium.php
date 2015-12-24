<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Stadium extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("stadiums", function(Blueprint $table){
            $table->increments("id");
            $table->string("name");
            $table->double("rating");
            $table->string("image", 500);
            $table->string("describe", 1500);
            $table->string("tel", 50);
            $table->string("link");
            $table->string("time_open");
            $table->string("time_close");
            $table->double("latitude");
            $table->double("longitude");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("stadiums");
    }
}
