<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationBackgroundsTable extends Migration
{
    public function up()
    {
        Schema::create('education_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->string('username'); // Foreign key reference
            $table->string('degree');
            $table->string('institution');
            $table->string('address');
            $table->integer('yearOfGraduation');
            $table->string('basicEducation');
            $table->string('highestLevel');
            // Removed honors field as it's not used
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('username')->references('username')->on('students')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('education_backgrounds', function (Blueprint $table) {
            $table->dropForeign(['username']);
        });

        Schema::dropIfExists('education_backgrounds');
    }
}
