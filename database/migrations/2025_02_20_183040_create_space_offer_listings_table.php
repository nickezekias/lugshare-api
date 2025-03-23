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
        Schema::create('space_offer_listings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('available_space_dimensions')->nullable();
            $table->string('available_weight');
            $table->string('delivery_preferences');
            $table->text('description');
            $table->string('flight_airline');
            $table->string('flight_arrival');
            $table->date('flight_arrival_date');
            $table->string('flight_booking_reference');
            $table->string('flight_departure');
            $table->date('flight_departure_date');
            $table->string('flight_number');
            $table->boolean('is_active')->default(true);
            $table->string('item_restrictions')->nullable();
            $table->string('price_per_unit');
            $table->text('special_instructions')->nullable();
            $table->string('status');
            $table->string('user_id', 36);
            $table->string('weightUnit');
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('space_offer_listings');
    }
};
