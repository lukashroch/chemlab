<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Password Reset Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the password broker for a password update attempt
    | has failed, such as for an invalid token or invalid new password.
    |
    */

    'reset' => 'Your password has been reset!',
    'sent' => 'We have e-mailed your password reset link!',
    'throttled' => 'Please wait before retrying.',
    'token' => 'This password reset token is invalid.',
    'user' => "We can't find a user with that e-mail address.",

    'no_account' => 'No account? Sign up!',
    'has_account' => 'Has account? Sign in!',

    '_' => 'Password',
    'current' => 'Current password',
    'no-match' => 'Current password doesn\'t match with out records!',
    'new' => 'New password',
    'confirmation' => 'Confirm new password',
    'change' => 'Change current password',
    'changed' => 'Password has been changed',
    'forbidden' => 'Forbidden expressions: :expressions or parts of your name',
    'forgot' => [
        '_' => 'Forgotten password?',
        'title' => 'Reset password',
        'send' => 'Send password reset request',
        'sent' => 'Link to restore your password has been sent to the provided email address.'
    ]
];
