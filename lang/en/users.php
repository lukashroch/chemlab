<?php

return [
    'title' => 'User',
    'index' => 'Users',
    'all' => 'All users',
    'show' => 'User detail',
    'new' => 'New user',
    'create' => 'Add user',
    'edit' => 'Edit user',
    'delete' => 'Delete user',

    'guest' => 'Guest',
    'details' => 'Details',
    'name' => 'Name',
    'email' => 'Email',
    'phone' => 'Phone',

    'password' => [
        '_' => 'Password',
        'current' => 'Current password',
        'no-match' => 'Current password doesn\'t match with out records!',
        'new' => 'New password',
        'confirmation' => 'Confirm new password',
        'forbidden' => 'Forbidden expressions: :expressions or parts of your name',
        'forgot' => 'Forgotten password?',
        'change' => 'Change current password',
        'changed' => 'Password has been changed',
        'reset' => [
            '_' => 'Reset password',
            'send' => 'Send password reset request',
            'sent' => 'Link to restore your password has been sent to the provided email address.',
        ],
    ],

    'remember' => 'Remember me',

    'roles' => [
        'none' => 'No role has been assigned with this permission.',
        'assigned' => 'Currently assigned roles',
        'not-assigned' => 'Available roles for assignment',
        'header' => 'Save the user header information before role assignment.',
    ]
];
