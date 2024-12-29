<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpRaiseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('exp_raise', function (Blueprint $table) {
        $table->id();
        $table->foreignId('aid')->constrained('admins'); // Adjust according to your table name for admins
        $table->foreignId('nontechmanagerid')->constrained('users'); // Adjust according to your table name for users
        $table->foreignId('groupid')->constrained('expenses');
        $table->foreignId('categoryid')->constrained('expense_cat');
        $table->foreignId('subcatid')->constrained('expense_subcat');
        $table->foreignId('itemid')->constrained('expense_item');
        $table->string('quantity_measure');
        $table->string('quantity');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('exp_raise');
}

}
