<?php

namespace App\Exceptions;

use Exception;

class EventAlreadyPresent extends Exception
{
    protected $message="event is already present in the database";
    public function render($request)
    {
        return response()->json(["error" => true, "message" => $this->getMessage()]);
    }
}
