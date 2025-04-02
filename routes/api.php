<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpaceBookingRequestController;
use App\Http\Controllers\SpaceOfferListingController;
use App\Http\Controllers\SpaceRequestListingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

Route::get('/home', function () {
    return response()->json(['error' => 'Already authenticated'], 200);
});

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/users/authenticated', function (Request $request) {
            return new UserResource(Auth::user());
        });

        Route::apiResource('/listings/space-offers', SpaceOfferListingController::class);

        Route::apiResource('/listings/space-requests', SpaceRequestListingController::class);
        
        Route::get('/space-booking-requests/current-user-and-space-offer', [SpaceBookingRequestController::class, 'showForCurrentUserAndSpaceOffer']);
        Route::put('/space-booking-requests/{id}/reject', [SpaceOfferListingController::class, 'rejectBooking']);
        Route::put('/space-booking-requests/{id}/accept', [SpaceOfferListingController::class, 'acceptBooking']);
        Route::apiResource('/space-booking-requests', SpaceBookingRequestController::class);
        
        Route::post('/profile/verifications/id-document', [ProfileController::class, 'verifyIDDocument']);
    });
});

// Other routes incoming
