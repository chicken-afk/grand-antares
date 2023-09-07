<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $code;
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->code = $code;
    }

    // Response Error
    public function render($request)
    {
        return response()->json(["success" => false, "status_code" => $this->code, "message" => $this->getMessage()], $this->code);
    }
}
