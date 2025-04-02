<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\SpaceBookingRequestResource as ObjResource;
use App\Models\SpaceBookingRequest as Obj;
use App\Models\SpaceOfferListing;

class SpaceBookingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $objects = [];
        $objectsQuery = Obj::where('space_offer_id', $request->spaceOfferId);
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
    public function store(Request $request)
    {
        //FIXME: check if the offered space is > to shipper desired_space
        Gate::authorize('create', Obj::class);
        $obj = new Obj;

        $request->validate([
            'desiredWeight' => 'required|int',
            'shipmentItems' => 'required|string',
            'itemsPickupDate' => 'required|string|max:255',
            'itemsPickupLocation' => 'required|string',
        ]);

        //FIXME: Handle data validation
        $obj->desired_weight = $request->input('desiredWeight');
        $obj->items_pickup_date = $request->input('itemsPickupDate');
        $obj->items_pickup_location = $request->input('itemsPickupLocation');
        $obj->shipment_items = $request->input('shipmentItems');
        $obj->space_offer_id = $request->input('spaceOfferId');
        $obj->status = Obj::STATUSES['PENDING'];
        $obj->user_id = $request->user()->id;

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
     * Display the specified resource for current user
     */
    public function showForCurrentUserAndSpaceOffer(Request $request)
    {
        $obj = Obj::where([['user_id', $request->user()->id], ['space_offer_id', $request->spaceOfferId]])->firstOrFail();

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

        //FIXME: validate space offer owner cannot book his own offer
        $request->validate([
            'desiredWeight' => 'required|int',
            'shipmentItems' => 'required|string',
            'itemsPickupDate' => 'required|string|max:255',
            'itemsPickupLocation' => 'required|string',
        ]);

        $obj->desired_weight = $request->input('desiredWeight');
        $obj->items_pickup_date = $request->input('itemsPickupDate');
        $obj->items_pickup_location = $request->input('itemsPickupLocation');
        $obj->shipment_items = $request->input('shipmentItems');
        $obj->status = Obj::STATUSES['OPEN'];

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
