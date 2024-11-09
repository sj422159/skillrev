<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolmenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schoolmenus', function (Blueprint $table) {
           $table->id();
            $table->string('aid');
            $table->string('catererid');
            $table->string('fitemid');
            $table->string('price');
            $table->string('catererpricetype');
            $table->string('catererprice');
            $table->string('sstatus');
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
        Schema::dropIfExists('schoolmenus');
    }
}
