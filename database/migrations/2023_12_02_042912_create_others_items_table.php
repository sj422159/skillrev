<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOthersItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('others_items', function (Blueprint $table) {
            $table->id();
            $table->string('aid');
            $table->string('mid');
            $table->string('roomid');
            $table->string('itemid');
            $table->string('itemcode');
            $table->string('itemno');
            $table->string('itemdesc');
            $table->string('repair');
            $table->string('history');
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
        Schema::dropIfExists('others_items');
    }
}
