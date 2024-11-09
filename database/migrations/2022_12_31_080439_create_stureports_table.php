<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStureportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stureports', function (Blueprint $table) {
            $table->id();
            $table->string('stid');
            $table->string('asstype');
            $table->string('ans');
            $table->string('assid');
            $table->string('secA');
            $table->string('secAmark');
            $table->string('secB');
            $table->string('secBmark');
            $table->string('secC');
            $table->string('secCmark');
            $table->string('secD');
            $table->string('secDmark');
            $table->string('result');
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
        Schema::dropIfExists('stureports');
    }
}
