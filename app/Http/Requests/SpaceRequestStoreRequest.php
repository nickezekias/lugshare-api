<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SpaceRequestStoreRequest extends FormRequest
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
            'description' => 'required|string|max:255',
            'flightArrival' => 'required|string|max:255',
            'flightDeparture' => 'required|string|max:255',
            'itemTypes' => 'required|string|max:255',
            'shipmentDate' => 'required|string|max:255',
            'shipmentDateFlexibility' => 'required|string|max:255',
            'shipperType' => 'required|string|max:255',
            'specialInstructions' => 'nullable|string',
            'userId' => ['required', 'string', Rule::unique('space_request_listings', 'user_id')->where(function ($query) {
                return $query->where('flight_arrival', $this->flightArrival)
                             ->where('shipment_date', $this->shipmentDate)
                             ->where('flight_departure', $this->flightDeparture);
            })],
            'weight' => 'required|int',
            'weightUnit' => 'required|string',
        ];
    }

    private function update(): array
    {
        $rules = $this->store();
        $rules['userId'] = ['required', 'string', Rule::unique('space_request_listings', 'user_id')->ignore($this->id)->where(function ($query) {
            return $query->where('flight_arrival', $this->flightArrival)
                         ->where('shipment_date', $this->shipment_date)
                         ->where('flight_departure', $this->flightDeparture);
        })];

        return $rules;
    }
}
