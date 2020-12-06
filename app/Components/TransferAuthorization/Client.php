<?php

namespace App\Components\TransferAuthorization;

use Exception;
use App\Components\TransferAuthorization\Contracts\TransferAuthorizationInterface;
use App\Components\Payments\Exceptions\TransferAuthorizationException;

class Client
{

    /**
     * @var $transferAuthorizationInterface
     */
    protected $transferAuthorizationInterface;

    /**
     * Client constructor.
     * @param TransferAuthorizationInterface $transferAuthorizationInterface
     */
    public function __construct(TransferAuthorizationInterface $transferAuthorizationInterface)
    {
        $this->transferAuthorizationInterface = $transferAuthorizationInterface;
    }

    /**     
     * @return Object
     * @throws TransferAuthorizationException
     */
    public function transferAuthorization(
    
    ): Object
    {
        try {
            return $this->transferAuthorizationInterface->transferAuthorization();
        } catch (Exception $exception) {
            throw new TransferAuthorizationException(
            $exception->getMessage(), $exception->getCode()
            );
        }
    }

}
