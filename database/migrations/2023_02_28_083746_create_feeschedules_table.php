<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeschedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeschedules', function (Blueprint $table) {
            $table->id();
            $table->string('aid');
            $table->string('shcategory');
            $table->string('shannual');
            $table->string('shhalf');
            $table->string('shquater');
            $table->string('shmonthly');
            $table->string('shtype');
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
        Schema::dropIfExists('feeschedules');
    }
}
