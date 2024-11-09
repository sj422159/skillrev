<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCafeteriainfrarepairhistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cafeteriainfrarepairhistories', function (Blueprint $table) {
             $table->id();
            $table->string('aid');
            $table->string('mid');
            $table->string('cafetype');
            $table->string('cafeid');
            $table->string('itemid');
            $table->string('itemno');
            $table->string('repairissued');
            $table->string('workstarted');
            $table->string('repairfinished');
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
        Schema::dropIfExists('cafeteriainfrarepairhistories');
    }
}
