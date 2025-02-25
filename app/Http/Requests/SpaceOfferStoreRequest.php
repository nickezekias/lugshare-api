<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SpaceOfferStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->id == $this->userId;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->isMethod('POST') ? $this->store() : $this->update();
    }

    private function store(): array
    {
        return [
            'availableSpaceDimensions' => 'nullable|string',
            'availableWeight' => 'required|int',
            'deliveryPreferences' => 'required|array',
            'description' => 'required|string',
            'flightAirline' => 'required|string',
            'flightArrival' => 'required|string',
            'flightArrivalDate' => 'required|date',
            'flightBookingReference' => 'required|string',
            'flightDeparture' => 'required|string',
            'flightDepartureDate' => 'required|date',
            'flightNumber' => 'required|string',
            'itemRestrictions' => 'nullable|array',
            'pricePerUnit' => 'required|string',
            'specialInstructions' => 'nullable|string',
            'userId' => ['required', 'string', Rule::unique('space_offer_listings', 'user_id')->where(function ($query) {
                return $query->where('flight_number', $this->flightNumber)
                             ->where('flight_booking_reference', $this->flightBookingReference);
            })],
            'weightUnit' => 'required|string',
        ];
    }

    private function update(): array
    {
        $rules = $this->store();
        $rules['userId'] = ['required', 'string', Rule::unique('space_offer_listings', 'user_id')->ignore($this->id)->where(function ($query) {
            return $query->where('flight_number', $this->flightNumber)
                         ->Where('flight_booking_reference', $this->flightBookingReference);
        })];

        return $rules;
    }
}
