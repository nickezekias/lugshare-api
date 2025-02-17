<?php

namespace App\Http\Resources;

use App\Helpers\Initials;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'avatar' => $this->avatar,
            'createdAt' => $this->created_at,
            'email' => $this->email,
            'emailVerifiedAt' => $this->email_verified_at,
            'firstName' => $this->first_name,
            'fullName' => $this->fullName(),
            'hasVerifiedEmail' => $this->hasVerifiedEmail(),
            'hasVerifiedID' => $this->hasVerifiedID(),
            'hasVerifiedPhone' => $this->hasVerifiedPhone(),
            'IDDocument' => $this->ID_document,
            'IDDocumentVerifiedAt' => $this->ID_document_verified_at,
            'initials' => Initials::generate("$this->last_name $this->first_name"),
            'isActive' => $this->is_active,
            'isAdmin' => $this->isAdmin(),
            'isOnboarded' => $this->isOnboarded(),
            'gender' => $this->gender,
            'lastName' => $this->last_name,
            'phone' => $this->phone,
            'occupation' => $this->occupation,
            'roles' => $this->roles,
            'phoneVerifiedAt' => $this->phone_verified_at,
            'updateAt' => $this->updated_at
        ];
    }
}
