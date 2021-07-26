<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamTypeShieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_type_shield', function (Blueprint $table) {
            $table->integer('shield_id')->unsigned()->index();
            $table->foreign('shield_id')->references('id')->on('shields')->onDelete('cascade');
            $table->integer('exam_type_id')->unsigned()->index();
            $table->foreign('exam_type_id')->references('id')->on('exam_types')->onDelete('cascade');
            
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
        Schema::dropIfExists('exam_type_shield');
    }
}
