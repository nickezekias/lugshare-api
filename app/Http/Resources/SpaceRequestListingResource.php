<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpaceRequestListingResource extends JsonResource
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
            'budget' => $this->budget,
            'description' => $this->description,
            'flightArrival' => $this->flight_arrival,
            'flightDeparture' => $this->flight_departure,
            'isActive' => $this->is_active,
            'itemTypes' => $this->item_types,
            'shipmentDate' => $this->shipment_date,
            'shipmentDateFlexibility' => $this->shipment_date_flexibility,
            'shipperType' => $this->shipper_type,
            'specialInstructions' => $this->special_instructions,
            'user' => $user,
            'userId' => $this->user_id,
            'weight' => $this->weight,
            'weightUnit' => $this->weightUnit,
            
        ];
    }
}
