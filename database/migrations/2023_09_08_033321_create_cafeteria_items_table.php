<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCafeteriaItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cafeteria_items', function (Blueprint $table) {
            $table->id();
             $table->string('aid');
            $table->string('mid');
            $table->string('cafetype');
            $table->string('cafeid');
            $table->string('itemid');
            $table->string('itemcode');
            $table->string('itemno');
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
        Schema::dropIfExists('cafeteria_items');
    }
}
