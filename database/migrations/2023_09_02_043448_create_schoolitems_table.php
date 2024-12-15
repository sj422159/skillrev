<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schoolitems', function (Blueprint $table) {
            $table->id();
             $table->string('aid');
            $table->string('mid');
            $table->string('classid');
            $table->string('sectionid');
            $table->string('itemid');
            $table->string('itemcode');
            $table->string('itemno');
            $table->string('facid');
            $table->string('repair');
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
        Schema::dropIfExists('schoolitems');
    }
}
