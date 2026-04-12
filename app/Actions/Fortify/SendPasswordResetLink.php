<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class SendPasswordResetLink
{
    public function sendResetLink(array $input): void
    {
        Validator::make(
            $input,
            [
                'email' => ['required', 'email'],
            ],
            [
                'email.required' => __('messages.email_required'),
                'email.email'    => __('messages.email_invalid'),
            ]
        )->validate();

        Password::sendResetLink(['email' => $input['email']]);
    }
}