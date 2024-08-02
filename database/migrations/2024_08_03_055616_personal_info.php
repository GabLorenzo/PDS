<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PersonalInfo extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('personal_info', function (Blueprint $table) {
            $table->id(); // Primary key
        
            $table->string('surname', 100);
            $table->string('firstname', 100);
            $table->string('middlename', 100)->nullable();
            $table->string('extname', 50)->nullable();
            $table->date('dob');
            $table->string('placeOfBirth', 255);
            $table->enum('sex', ['Male', 'Female']);
            $table->enum('citizenship', ['Filipino', 'Dual']);
            $table->enum('dualType', ['By Birth', 'By Naturalization'])->nullable();
            $table->string('dualCountry', 100)->nullable();
            $table->float('height', 5, 2); // Allowing for height like 1.75m
            $table->float('weight', 5, 2); // Allowing for weight like 70.5kg
            $table->string('bloodType', 5)->nullable();
            $table->enum('civilStatus', ['Single', 'Married', 'Widowed', 'Separated', 'Divorced']);
            $table->string('email', 255);
            $table->timestamps(); // Created at & Updated at

            // Setting up the foreign key constraint
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_info');
    }
};
