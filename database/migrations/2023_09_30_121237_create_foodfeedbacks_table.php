<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodfeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foodfeedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('stu_id');
            $table->string('hostelid');
            $table->string('day');
            $table->string('date');
            $table->string('quantity');
            $table->string('quality');
            $table->string('taste');
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
        Schema::dropIfExists('foodfeedbacks');
    }
}
