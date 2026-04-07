<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        Validator::make(
            $input,
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                ],
                'password' => $this->passwordRules(),

                'password_confirmation' => ['required', 'same:password'],
            ],

            [
                'name.required'     => __('messages.name_required'),
                'name.max'          => __('messages.name_max'),
                'email.required'    => __('messages.email_required'),
                'email.email'       => __('messages.email_invalid'),
                'email.unique'      => __('messages.email_taken'),
                'password.required' => __('messages.password_required'),
                'password.confirmed' => __('messages.password_confirmed'),

                'password_confirmation.same' => __('messages.password_confirmed'),
                'password_confirmation.required' => __('messages.password_confirmed'), // Messaggio opzionale se lasciano il campo vuoto
            ]
        )->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
