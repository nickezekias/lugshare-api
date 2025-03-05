<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\SpaceRequestListingResource as ObjResource;
use App\Models\SpaceRequestListing as Obj;
use App\Http\Requests\SpaceRequestStoreRequest as ObjRequest;

class SpaceRequestListingController extends Controller
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
    public function store(ObjRequest $request)
    {
        Gate::authorize('create', Obj::class);

        $obj = new Obj;

        $obj->budget = $request->input('budget');
        $obj->description = $request->input('description');
        $obj->flight_arrival = $request->input('flightArrival');
        $obj->flight_departure = $request->input('flightDeparture');
        $obj->is_active = true;
        $obj->item_types = $request->input('itemTypes');
        $obj->shipment_date = $request->input('shipmentDate');
        $obj->shipment_date_flexibility = $request->input('shipmentDateFlexibility');
        $obj->shipper_type = $request->input('shipperType');
        $obj->special_instructions = $request->input('specialInstructions');
        $obj->user_id = $request->input('userId');
        $obj->weight = $request->input('weight');
        $obj->weight_unit = $request->input('weightUnit');

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
    public function update(ObjRequest $request, string $id)
    {
        $obj = Obj::findOrFail($id);

        Gate::authorize('update', $obj);

        $obj->budget = $request->input('budget');
        $obj->description = $request->input('description');
        $obj->flight_arrival = $request->input('flightArrival');
        $obj->flight_departure = $request->input('flightDeparture');
        $obj->item_types = $request->input('itemTypes');
        $obj->shipment_date = $request->input('shipmentDate');
        $obj->shipment_date_flexibility = $request->input('shipmentDateFlexibility');
        $obj->shipper_type = $request->input('shipperType');
        $obj->special_instructions = $request->input('specialInstructions');
        $obj->user_id = $request->input('userId');
        $obj->weight = $request->input('weight');
        $obj->weight_unit = $request->input('weightUnit');

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

        if ($obj->delete()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false], 400);
        }
    }
}
