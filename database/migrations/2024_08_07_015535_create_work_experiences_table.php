    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateWorkExperiencesTable extends Migration
    {
        public function up()
        {
            Schema::create('work_experiences', function (Blueprint $table) {
                $table->id();
                $table->string('username');
                $table->string('address');
                $table->string('contact');
                $table->string('inclusive_dates');
                $table->string('position_title');
                $table->string('department');
                $table->decimal('monthly_salary', 10, 2);
                $table->string('salary_grade');
                $table->string('appointment_status');
                $table->string('govt_service');
                $table->foreign('username')->references('username')->on('students')->onDelete('cascade');
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::table('work_experiences', function (Blueprint $table) {
                $table->dropForeign(['username']);
            });

            Schema::dropIfExists('work_experiences');
        }
    }
