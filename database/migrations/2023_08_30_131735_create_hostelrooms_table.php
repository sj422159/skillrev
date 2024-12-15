<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostelroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hostelrooms', function (Blueprint $table) {
            $table->id();
            $table->string('aid');
            $table->string('mid');
            $table->string('roomname');
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
        Schema::dropIfExists('hostelrooms');
    }
}
