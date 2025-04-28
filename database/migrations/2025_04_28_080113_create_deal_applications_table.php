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
        Schema::create('deal_applications', function (Blueprint $table) {
            $table->id();
            $table->string('customer_wallet');
            $table->bigInteger('builder_id');
            $table->bigInteger('flat_id');
            $table->bigInteger('project_id');
            /*
             * 1 - NEW
             * 2 - CONFIRM
             * 3 - REJECT
             * */
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_applications');
    }
};
