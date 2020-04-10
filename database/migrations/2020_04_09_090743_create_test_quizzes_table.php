<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_quizzes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('test_part_id');
            $table->integer('number');
            $table->integer('quiz_type');
            $table->string('question');
            $table->text('options')->nullable();
            $table->string('answer');
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
        Schema::dropIfExists('test_quizzes');
    }
}
