<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id');
            $table->unsignedInteger('miles');
            $table->unsignedInteger('total');
            $table->timestamp('date');
            $table->timestamps();

            $table->foreign('car_id')->references('id')->on('cars');
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
}
