<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
//            $table->string('customer_id');
            $table->unsignedInteger('department_id');
            $table->string('username');
            $table->string('password');
            $table->string('name');
            $table->string('address');
            $table->string('email');
            $table->string('phone', 20);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
