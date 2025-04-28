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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('customer_wallet');
            $table->string('dao_wallet');
            $table->string('builder_wallet');
            $table->string('amount');
            $table->text('mnemonic');
            $table->string('public_key');
            $table->string('private_key');
            /*
             * 1 - AMOUNT IN ESCROW
             * 2 - PAYED TO DEVELOPER
             * 3 - RETURN TO CUSTOMER
             * */
            $table->integer('status')->default(1);
            $table->bigInteger('flat_id');
            $table->bigInteger('project_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
