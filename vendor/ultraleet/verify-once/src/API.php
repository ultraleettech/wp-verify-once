<?php

namespace Ultraleet\VerifyOnce;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Ultraleet\VerifyOnce\Data\InitiateResponse;
use Ultraleet\VerifyOnce\Exceptions\AuthenticationException;

class API
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var HttpClient
     */
    protected $client;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Post an initiate request and return the response.
     *
     * @return InitiateResponse
     * @throws AuthenticationException
     */
    public function initiate(): InitiateResponse
    {
        try {
            $response = $this->getClient()->post('initiate');
        } catch (ClientException $exception) {
            if (401 == $exception->getResponse()->getStatusCode()) {
                throw new AuthenticationException('Invalid username/password provided.', 401, $exception);
            }
            throw $exception;
        }
        return new InitiateResponse(json_decode($response->getBody()));
    }

    /**
     * @return HttpClient
     */
    public function getClient(): HttpClient
    {
        if (! isset($this->client)) {
            $credentials = base64_encode("{$this->config['username']}:{$this->config['password']}");
            $this->setClient(
                new HttpClient(
                    [
                        'base_uri' => $this->config['baseUrl'],
                        'headers' => [
                            'Accept' => 'application/json',
                            'Authorization' => "Basic $credentials",
                        ],
                    ]
                )
            );
        }
        return $this->client;
    }

    /**
     * @param HttpClient $client
     */
    public function setClient(HttpClient $client): void
    {
        $this->client = $client;
    }
}
