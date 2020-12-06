<?php

namespace App\Components\Payments\Exceptions;

use Exception;
use Throwable;
use Illuminate\Support\Facades\Log;

class PaymentException extends Exception
{
    /**
     * PaymentException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        $message = '',
        $code = 500,
        Throwable $previous = null
    ) {
        Log::error('Payment Error: ' . $message);
        parent::__construct($message, $code, $previous);
    }
}
