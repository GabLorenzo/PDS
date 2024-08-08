<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_info', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('surname');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('extname')->nullable();
            $table->date('dob');
            $table->string('place_of_birth');
            $table->string('sex');
            $table->string('citizenship');
            $table->string('dualType')->nullable();
            $table->string('dualCountry')->nullable();
            $table->decimal('height', 5, 2);
            $table->decimal('weight', 5, 2);
            $table->string('bloodType')->nullable();
            $table->string('civil_status');
            $table->string('email');
            $table->foreign('user_id')->references('username')->on('students')->onDelete('cascade');
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
        Schema::dropIfExists('personal_info');
    }
}
