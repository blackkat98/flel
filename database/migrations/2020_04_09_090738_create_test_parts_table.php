<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('test_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('images')->nullable();
            $table->string('sound')->nullable();
            $table->string('video')->nullable();
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
        Schema::dropIfExists('test_parts');
    }
}
