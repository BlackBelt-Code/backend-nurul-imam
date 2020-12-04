<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModifyClassStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('class_student', function (Blueprint $table) {
            $table->bigInteger('student_id')->unsigned()->change();
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade');

            $table->bigInteger('class_id')->unsigned()->change();
            $table->foreign('class_id')->references('id')->on('class')->onUpdate('cascade');

            $table->bigInteger('type_class_id')->unsigned()->change();
            $table->foreign('type_class_id')->references('id')->on('type_class')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('class_student', function (Blueprint $table) {
            $table->dropForeign('class_student_student_id_foreign');
            $table->dropForeign('class_student_class_id_foreign');
            $table->dropForeign('class_student_type_class_id_foreign');
        });
    }
}
