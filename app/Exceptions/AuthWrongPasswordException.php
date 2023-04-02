<?php

namespace App\Exceptions;

use Exception;

class AuthWrongPasswordException extends Exception
{
    protected $message = 'Wrong pass.';

    public function render()
    {
        return response()->json([
            'error' => class_basename($this),
            'message' => $this->message
        ], 400);
    }
}
