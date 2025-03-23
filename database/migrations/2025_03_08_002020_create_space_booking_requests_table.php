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
        Schema::create('space_booking_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('space_offer_id', 36);
            $table->unsignedSmallInteger('desired_weight');
            $table->text('shipment_items');
            $table->string('items_pickup_date')->nullable();
            $table->string('items_pickup_location')->nullable();
            $table->string('status');
            $table->string('traveler_response')->nullable();
            $table->string('user_id', 36);
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('space_booking_requests');
    }
};
