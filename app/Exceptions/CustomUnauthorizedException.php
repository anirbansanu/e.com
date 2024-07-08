<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class CustomUnauthorizedException extends Exception
{
    protected $action;

    public function __construct($action, $message = "Unauthorized", $code = 403)
    {
        $this->action = $action;
        $message .= ' ' . $action;
        parent::__construct($message, $code);

        // Log the unauthorized access
        $this->logError();
    }

    protected function logError()
    {
        Log::warning('Unauthorized access attempt: ' . $this->message);
    }

    public function render($request)
    {
        if ($request->expectsJson()) {
            return new JsonResponse([
                'error' => 'Unauthorized',
                'message' => $this->getMessage(),
            ], $this->getCode());
        }

        return response()->view('errors.403', ['message' => $this->getMessage()], $this->getCode());
    }
}
