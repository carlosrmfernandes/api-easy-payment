<?php

namespace App\Components\Payments\Strategies;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Components\Payments\Contracts\PaymentInterface;
use App\Components\Payments\Exceptions\PaymentException;

class HopeStrategy implements PaymentInterface
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * PaidMaxiStrategy constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $data
     * @return Object
     * @throws Exception
     */
    public function generatePayment(
    array $data
    ): Object
    {
        try {

            $response = $this->client->request('POST', '/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04', [
                'json' => $data,
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (ClientException $exception) {
            $response = json_decode($exception->getResponse()->getBody()->getContents());

            throw new PaymentException(
            $response->message, $exception->getCode()
            );
        } catch (Exception $exception) {
            throw $exception;
        }
    }

}
