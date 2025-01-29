<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasUuids, Notifiable, SoftDeletes;

    const GENDERS_LIST = [
        'MALE' => 'male',
        'FEMALE' => 'female'
    ];

    const ROLES_LIST = [
        'ADMIN' => 'admin',
        'USER' => 'user',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'avatar',
        'first_name',
        'last_name',
        'email',
        'gender',
        'ID_document',
        'occupation',
        'phone',
        'password',
        'roles',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'ID_document_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
            'roles' => 'array'
        ];
    }

    public function assignRoles(array $roles): void
    {
        if (!in_array($roles, self::ROLES_LIST)) {
            throw new \App\Exceptions\UknownRoleException("Unknown role $roles");
        }
        $this->roles = array_unique(array_merge($this->roles, $roles));
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function fullName(): string
    {
        return $this->last_name." ".$this->first_name;
    }

    public function isAdmin(): bool
    {
        return in_array(self::ROLES_LIST['ADMIN'], $this->roles);
    }
}
