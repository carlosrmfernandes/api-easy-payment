<?php

namespace App\Components\Payments\Contracts;

interface PaymentInterface
{

    /**
     * @param array $data
     * @return Object
     */
    public function generatePayment(
        array $data
    ): Object;
}
