<?php

namespace App\Models;

use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceBookingRequest extends Model
{
    use HasUuids, SoftDeletes;

    const STATUSES = [
        'ACCEPTED' => 'accepted',
        'COMPLETED' => 'completed',
        'CANCELLED' => 'cancelled',
        'PENDING' => 'pending',
        'REJECTED' => 'rejected'
    ];

    public function user()
    {
        $user = User::findOrFail($this->user_id);
        return new UserResource($user);
    }
}
