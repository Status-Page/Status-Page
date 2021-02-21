<?php

namespace App\Exceptions;

use Exception;

class UserDeactivatedException extends Exception
{
    protected $code = 520;
    protected $message = 'Your Account is disabled.';

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        // Determine if the exception needs custom reporting...

        return false;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response(view('errors.423'));
    }
}
