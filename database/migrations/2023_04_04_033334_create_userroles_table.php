<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserrolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userroles', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('subrole');
            $table->string('portal');
            $table->string('subportal');
            $table->string('fname');
            $table->string('lname');
            $table->string('mobile');
            $table->string('email');
            $table->string('branchoffice');
            $table->string('worklocation');
            $table->string('aadhar');
            $table->string('employmentstatus');
            $table->string('status');
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
        Schema::dropIfExists('userroles');
    }
}
