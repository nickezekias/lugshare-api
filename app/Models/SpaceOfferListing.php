<?php

namespace App\Models;

use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceOfferListing extends Model
{
    use HasUuids, SoftDeletes;

    const STATUSES = [
        'BOOKED' => 'booked',
        'AVAILABLE' => 'available',
        'UNAVAILABLE' => 'unavailable'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'delivery_preferences' => 'array',
            'is_active' => 'boolean',
            'item_restrictions' => 'array'
        ];
    }

    public function user()
    {
        $user = User::findOrFail($this->user_id);
        return new UserResource($user);
    }

    public function isBooked()
    {
        return $this->status === self::STATUSES['BOOKED'];
    }

    public function isAvailable()
    {
        return $this->status === self::STATUSES['AVAILABLE'];
    }

    public function isUnavailable()
    {
        return $this->status === self::STATUSES['UNAVAILABLE'];
    }
}
