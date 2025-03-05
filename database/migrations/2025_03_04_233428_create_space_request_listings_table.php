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
        Schema::create('space_request_listings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('budget');
            $table->string('description');
            $table->string('flight_arrival');
            $table->string('flight_departure');
            $table->boolean('is_active')->default(true);
            $table->string('item_types');
            $table->date('shipment_date');
            $table->string('shipment_date_flexibility');
            $table->string('shipper_type');
            $table->string('special_instructions')->nullable();
            $table->string('user_id', 36);
            $table->string('weight');
            $table->string('weight_unit');
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('space_request_listings');
    }
};
