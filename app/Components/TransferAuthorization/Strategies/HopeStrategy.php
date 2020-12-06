<?php

namespace App\Components\TransferAuthorization\Strategies;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Components\TransferAuthorization\Contracts\TransferAuthorizationInterface;
use App\Components\Payments\Exceptions\TransferAuthorizationException;

class HopeStrategy implements TransferAuthorizationInterface
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * HopeStrategy constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Object
     * @throws Exception
     */
    public function transferAuthorization(
    ): Object
    {
        
        try {
            $response = $this->client->request('GET', '/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
            
            return json_decode($response->getBody()->getContents());
        } catch (ClientException $exception) {
            $response = json_decode($exception->getResponse()->getBody()->getContents());
            throw new TransferAuthorizationException(
            $response->message, $exception->getCode()
            );
        } catch (Exception $exception) {
            throw $exception;
        }
    }

}
