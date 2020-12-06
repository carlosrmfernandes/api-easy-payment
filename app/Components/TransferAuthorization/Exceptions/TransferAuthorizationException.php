<?php

namespace App\Components\Payments\Exceptions;

use Exception;
use Throwable;
use Illuminate\Support\Facades\Log;

class TransferAuthorizationException extends Exception
{
    /**
     * TransferAuthorizationException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        $message = '',
        $code = 500,
        Throwable $previous = null
    ) {
        Log::error('Transfer Authorization Error: ' . $message);
        parent::__construct($message, $code, $previous);
    }
}
