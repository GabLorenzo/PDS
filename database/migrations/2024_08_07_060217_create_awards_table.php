<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardsTable extends Migration
{
    public function up()
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->string('username'); // Foreign key to the students table
            $table->string('awardType'); // New column for award type
            $table->string('name'); // Award name
            $table->text('description'); // Award description
            $table->timestamps();

            $table->foreign('username')->references('username')->on('students')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('awards');
    }
}
