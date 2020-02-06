<?php

namespace Chemlab\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidCurrentPassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $user = auth()->user();
        return auth()->attempt(['email' => $user->email, 'password' => $value]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('users.password.no-match');
    }
}
