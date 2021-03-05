<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        return ['required', 'string', new Password, 'confirmed'];
    }

    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function consolePasswordRules()
    {
        return ['required', 'string', new Password];
    }

    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function updatePasswordRules()
    {
        return ['string', new Password];
    }
}
