<?php

namespace App\Components\Payments;

use Exception;
use App\Components\Payments\Contracts\PaymentInterface;
use App\Components\Payments\Exceptions\PaymentException;

class Client
{
    /**
     * @var paymentInterface
     */
    protected $paymentInterface;

    /**
     * Client constructor.
     * @param PaymentInterface $paymentInterface
     */
    public function __construct(PaymentInterface $paymentInterface)
    {
        $this->paymentInterface = $paymentInterface;
    }

    /**
     * @param array $data
     * @return Object
     * @throws PaymentException
     */
    public function generatePayment(
        array $data
    ): Object {
        try {
            return $this->paymentInterface->generatePayment(
                $data
            );
        } catch (Exception $exception) {
            throw new PaymentException(
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }
}
