<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('uid')->index();
            $table->integer('shield_id')->unsigned()->index();
            $table->foreign('shield_id')->references('id')->on('shields')->onDelete('cascade');
            $table->decimal('normlow', 10, 6)->nullable();
            $table->decimal('normhigh', 10, 6)->nullable();
            $table->string('unit')->nullable();
            $table->string('description', 4000)->nullable();
            $table->timestamps();

            $table->unique(['id', 'shield_id']);
            $table->unique(['uid', 'shield_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensors');
    }
}
