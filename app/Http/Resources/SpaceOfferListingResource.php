<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpaceOfferListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $owner = $this->user();
        $user = [
            'firstName' => $owner->first_name,
            'lastName' => $owner->last_name,
            'id' => $owner->id,
            'initials' => $owner->initials,
        ];

        return [
            'id' => $this->id,
            'availableSpaceDimensions' => $this->available_space_dimensions,
            'availableWeight' => $this->available_weight,
            'deliveryPreferences' => $this->delivery_preferences,
            'description' => $this->description,
            'flightAirline' => $this->flight_airline,
            'flightArrival' => $this->flight_arrival,
            'flightArrivalDate' => $this->flight_arrival_date,
            'flightBookingReference' => $this->flight_booking_reference,
            'flightDeparture' => $this->flight_departure,
            'flightDepartureDate' => $this->flight_departure_date,
            'flightNumber' => $this->flight_number,
            'itemRestrictions' => $this->item_restrictions,
            'pricePerUnit' => $this->price_per_unit,
            'specialInstructions' => $this->special_instructions,
            'userId' => $this->user_id,
            'user' => $user,
            'weightUnit' => $this->weightUnit,
        ];
    }
}
