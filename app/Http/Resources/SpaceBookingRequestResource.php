<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\Initials;

class SpaceBookingRequestResource extends JsonResource
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
            'fullName' => "$owner->first_name $owner->last_name",
            'lastName' => $owner->last_name,
            'id' => $owner->id,
            'initials' => Initials::generate("$owner->last_name $owner->first_name"),
        ];

        return [
            'createdAt' => $this->created_at,
            'desiredWeight' => $this->desired_weight,
            'id' => $this->id,
            'itemsPickupDate' => $this->items_pickup_date,
            'itemsPickupLocation' => $this->items_pickup_location,
            'shipmentItems' => $this->shipment_items,
            'spaceOfferId' => $this->space_offer_id,
            'status' => $this->status,
            'updatedAt' => $this->updated_at,
            'user' => $user,
            'userId' => $this->user_id
        ];
    }
}
