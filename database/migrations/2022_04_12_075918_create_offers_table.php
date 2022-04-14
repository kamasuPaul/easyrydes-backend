<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount');
            $table->enum('status',['pending','accepted','rejected']);
            $table->unsignedBigInteger('listing_id');
            $table->unsignedBigInteger('user_id');
            $table->date('start_date')->nullable();//
            $table->date('end_date')->nullable();
            $table->string('description');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            //add relationships
            $table->foreign('listing_id')->references('listing_id')->on('listings')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
