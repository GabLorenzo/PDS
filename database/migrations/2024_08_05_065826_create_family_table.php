<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('family', function (Blueprint $table) {
            $table->id();
            $table->string('user_id'); // assuming 'user_id' is the foreign key
            $table->string('relation');
            $table->string('name');
            $table->integer('age')->nullable();
            $table->string('occupation')->nullable();
            $table->string('contactNumber')->nullable();
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('user_id')->references('username')->on('students')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family');
    }
}

