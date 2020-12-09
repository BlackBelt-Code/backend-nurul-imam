<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModifyNisnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nisn', function (Blueprint $table) {
            $table->bigInteger('student_id')->unsigned()->change();
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nisn', function (Blueprint $table) {
            $table->dropForeign('nisn_student_id_foreign');
        });
    }
}
