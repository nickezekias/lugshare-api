<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\SpaceOfferListingResource as ObjResource;
use App\Models\SpaceOfferListing as Obj;
use App\Http\Requests\SpaceOfferStoreRequest;


class SpaceOfferListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $objects = [];
        $objectsQuery = Obj::where('id', '>', 0);
        if ($request->has('sortBy')) {
            $orderByArray = explode(',', $request->sortBy);
            $orderByOrientation = explode(',', $request->sortDesc);
            for ($i = 0; $i < count($orderByArray); $i++) {
                if ($orderByOrientation[$i] === 'true') {
                    $objectsQuery->orderBy($orderByArray[$i], 'desc');
                } else {
                    $objectsQuery->orderBy($orderByArray[$i], 'asc');
                }
            }
        }

        if ($request->has('itemsPerPage')) {
            if ($request->itemsPerPage == -1) {
                $objects = $objectsQuery->get();
            } else {
                $objects = $objectsQuery->paginate($request->itemsPerPage);
            }
        } else {
            $objects = $objectsQuery->paginate();
        }

        return ObjResource::collection($objects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpaceOfferStoreRequest $request)
    {
        Gate::authorize('create', Obj::class);

        $obj = new Obj;

        $obj->available_space_dimensions = $request->availableSpaceDimensions;
        $obj->available_weight = $request->availableWeight;
        $obj->delivery_preferences = $request->deliveryPreferences;
        $obj->description = $request->description;
        $obj->flight_airline = $request->flightAirline;
        $obj->flight_arrival = $request->flightArrival;
        $obj->flight_arrival_date = $request->flightArrivalDate;
        $obj->flight_booking_reference = $request->flightBookingReference;
        $obj->flight_departure = $request->flightDeparture;
        $obj->flight_departure_date = $request->flightDepartureDate;
        $obj->flight_number = $request->flightNumber;
        $obj->is_active = true;
        $obj->item_restrictions = $request->itemRestrictions;
        $obj->price_per_unit = $request->pricePerUnit;
        $obj->special_instructions = $request->specialInstructions;
        $obj->user_id = $request->userId;
        $obj->weightUnit = $request->weightUnit;

        $obj->save();

        return new ObjResource($obj);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $obj = Obj::findOrFail($id);

        Gate::authorize('view', $obj);

        return new ObjResource($obj);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $obj = Obj::findOrFail($id);

        Gate::authorize('update', $obj);

        $obj->available_space_dimensions = $request->availableSpaceDimensions;
        $obj->available_weight = $request->availableWeight;
        $obj->delivery_preferences = $request->deliveryPreferences;
        $obj->description = $request->description;
        $obj->flight_airline = $request->flightAirline;
        $obj->flight_arrival = $request->flightArrival;
        $obj->flight_arrival_date = $request->flightArrivalDate;
        $obj->flight_booking_reference = $request->flightBookingReference;
        $obj->flight_departure = $request->flightDeparture;
        $obj->flight_departure_date = $request->flightDepartureDate;
        $obj->flight_number = $request->flightNumber;
        $obj->item_restrictions = $request->itemRestrictions;
        $obj->price_per_unit = $request->pricePerUnit;
        $obj->special_instructions = $request->specialInstructions;
        $obj->weightUnit = $request->weightUnit;

        $obj->save();

        return new ObjResource($obj);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $obj = Obj::findOrFail($id);

        Gate::authorize('delete', $obj);

        if($obj->delete()) {
            return response()->json([ 'success' => true ]);
        } else {
            return response()->json(['success' => false], 400);
        }
    }
}
