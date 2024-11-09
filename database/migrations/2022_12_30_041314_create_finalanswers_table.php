<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalanswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finalanswers', function (Blueprint $table) {
            $table->id();
            $table->string('stid');
            $table->string('assid');
            $table->string('abid');
            $table->string('questionid');
            $table->string('answer');
            $table->string('questionno');
            $table->string('confident');
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
        Schema::dropIfExists('finalanswers');
    }
}
