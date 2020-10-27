<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->bigIncrements('model_id');
            $table->string('model_name');
            $table->string('cylinder');
            $table->string('engine_description');
            $table->string('wheel_drive');
            $table->string('fuel_consumption');
            $table->string('fuel_type');
            $table->string('transition');
            $table->string('body_type');
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
        Schema::dropIfExists('models');
    }
}
