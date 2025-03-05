<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\UserResource;

class SpaceRequestListing extends Model
{
    use HasUuids, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'item_types' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function user()
    {
        $user = User::findOrFail($this->user_id);
        return new UserResource($user);
    }
}
