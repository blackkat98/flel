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
            $table->integer('associated_quiz_id');
            $table->integer('quiz_type');
            $table->string('question');
            $table->text('images')->nullable();
            $table->string('sound')->nullable();
            $table->string('video')->nullable();
            $table->text('essay')->nullable();
            $table->text('options')->nullable(); //edit this
            $table->text('answer');
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
