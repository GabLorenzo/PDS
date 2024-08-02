<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddressInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_info', function (Blueprint $table) {
            $table->id()->primary();
            $table->boolean('address_type');
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('barangay')->nullable();
            $table->string('house_number')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('temp_country')->nullable();
            $table->string('temp_province')->nullable();
            $table->string('temp_city')->nullable();
            $table->string('temp_barangay')->nullable();
            $table->string('temp_house_number')->nullable();
            $table->string('temp_zip_code')->nullable();
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
        Schema::dropIfExists('address_info');
    }
}