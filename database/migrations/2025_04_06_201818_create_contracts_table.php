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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_data_id');
            $table->timestamp('contract_date')->nullable();
            $table->timestamp('end_of_contract_date')->nullable();
            $table->string('price_per_month')->nullable();
            $table->string('total_months')->nullable();
            $table->string('notes')->nullable();
            $table->json('photos')->nullable();
            $table->timestamps();

            $table->foreign('owner_data_id')
                ->references('id')
                ->on('owner_data')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};