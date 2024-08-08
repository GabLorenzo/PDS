<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id(); // Or use $table->bigIncrements('id'); for older versions
            $table->string('user_id');
            $table->string('address_type')->nullable();
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('barangay')->nullable();
            $table->string('house_number')->nullable();
            $table->string('zip_code')->nullable();
            $table->timestamps();

            // Add any indexes or foreign key constraints if necessary
            $table->foreign('user_id')->references('username')->on('students');
            $table->unique(['user_id', 'address_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
