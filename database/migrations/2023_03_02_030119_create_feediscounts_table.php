<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeediscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feediscounts', function (Blueprint $table) {
            $table->id();
            $table->string('aid');
            $table->string('stu_id');
            $table->string('discat');
            $table->string('discls');
            $table->string('dissec');
            $table->string('distype');
            $table->string('fees');
            $table->string('dis');
            $table->string('disprice');
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
        Schema::dropIfExists('feediscounts');
    }
}
