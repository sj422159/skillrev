<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostelitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hostelitems', function (Blueprint $table) {
           $table->id();
            $table->string('aid');
            $table->string('mid');
            $table->string('hostelid');
            $table->string('roomid');
            $table->string('itemid');
            $table->string('itemcode');
            $table->string('itemno');
            $table->string('stu_id');
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
        Schema::dropIfExists('hostelitems');
    }
}
