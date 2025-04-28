<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id');
            $table->string('apartment_number');
            $table->string('area');
            $table->integer('floor');
            $table->integer('rooms');
            $table->string('price');
            /*
             * 0 - INACTIVE
             * 1 - ACTIVE
             * 2 - SOLD
             * */
            $table->integer('status');
            $table->integer('balcony');
            $table->integer('parking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flats');
    }
};
