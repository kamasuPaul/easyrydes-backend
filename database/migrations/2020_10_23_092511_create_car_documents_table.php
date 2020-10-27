<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_documents', function (Blueprint $table) {
            $table->id();
            $table->string('proof_of_registration');
            $table->string('proof_of_insurance');
            $table->string('proof_of_inspection');
            $table->timestamps();
            $table->foreignId('listing_id');
            $table->foreign('listing_id')->references('listing_id')->on('listings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_documents');
    }
}
