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
        Schema::create('owner_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('corner_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('township_id');
            $table->unsignedBigInteger('ward_id');
            $table->unsignedBigInteger('street_id');
            $table->unsignedBigInteger('wifi_id');
            $table->string('land_no');
            $table->string('house_no');
            $table->string('property');
            $table->string('meter_no');
            $table->string('meter_bill_code');
            $table->string('wifi_user_id');
            $table->unsignedBigInteger('land_id')->nullable();
            $table->string('issuance_date')->nullable();
            $table->string('expired')->nullable();
            $table->unsignedBigInteger('renter_id')->nullable();
            $table->timestamp('contract_date')->nullable();
            $table->timestamp('end_of_contract_date')->nullable();
            $table->string('price_per_month')->nullable();
            $table->string('total_months')->nullable();
            $table->string('notes')->nullable();
            $table->json('photos')->nullable();

            $table->auditColumns();

            $table->foreign('owner_id')
                ->references('id')
                ->on('owners')
                ->onDelete('cascade');

            $table->foreign('corner_id')
                ->references('id')
                ->on('corners')
                ->onDelete('cascade');

            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade');

            $table->foreign('township_id')
                ->references('id')
                ->on('townships')
                ->onDelete('cascade');

            $table->foreign('ward_id')
                ->references('id')
                ->on('wards')
                ->onDelete('cascade');

            $table->foreign('street_id')
                ->references('id')
                ->on('streets')
                ->onDelete('cascade');

            $table->foreign('wifi_id')
                ->references('id')
                ->on('wifis')
                ->onDelete('cascade');

            $table->foreign('land_id')
                ->references('id')
                ->on('lands')
                ->onDelete('cascade');

            $table->foreign('renter_id')
                ->references('id')
                ->on('renters')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_data');
    }
};

