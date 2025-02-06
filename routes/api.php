<?php

use App\Http\Controllers\ProfileController;
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

        Route::post('/profile/verifications/id-document', [ProfileController::class, 'verifyIDDocument']);
    });
});

// Other routes incoming
