<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'gender' => ['required', 'string', 'max:50', Rule::in(User::GENDERS_LIST)],
            'phone' => ['required', 'string', 'max:255', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'first_name' => $input['firstName'],
            'last_name' => $input['lastName'],
            'email' => $input['email'],
            'gender' => $input['gender'],
            'phone' => $input['phone'],
            'password' => Hash::make($input['password']),
            'roles' => [User::ROLES_LIST['USER']],
        ]);
    }
}
