<?php

namespace Ultraleet\VerifyOnce;

use Firebase\JWT\JWT;
use Ultraleet\VerifyOnce\Data\CallbackInfo;
use Ultraleet\VerifyOnce\Data\InitiateResponse;
use Ultraleet\VerifyOnce\Exceptions\InvalidConfigException;
use Ultraleet\VerifyOnce\Exceptions\AuthenticationException;

/**
 * VerifyOnce integration library main class.
 *
 * @package ultraleet/verify-once
 */
final class VerifyOnce
{
    const ALGORITHMS = ['HS256', 'HS384', 'HS512'];

    /**
     * @var array
     */
    private $config;

    /**
     * @var API
     */
    private $api;

    /**
     * VerifyOnce constructor.
     *
     * @param array $config
     * @throws InvalidConfigException
     */
    public function __construct(array $config)
    {
        $this->configure($config);
    }

    /**
     * Initiate verification and return the response from VerifyOnce API.
     *
     * @return InitiateResponse
     * @throws AuthenticationException
     */
    public function initiate(): InitiateResponse
    {
        return $this->getApi()->initiate();
    }

    /**
     * Verify the callback info and return the decoded array.
     *
     * Throws an exception in case verification fails.
     *
     * @param string $body
     * @return CallbackInfo
     */
    public function verify(string $body): CallbackInfo
    {
        $decoded = JWT::decode($body, $this->config['password'], self::ALGORITHMS);
        $decoded = json_decode(json_encode($decoded), true);
        return new CallbackInfo($decoded);
    }

    /**
     * Verify configuration and merge with defaults.
     *
     * @param array $config
     * @throws InvalidConfigException
     */
    private function configure(array $config)
    {
        $this->validateConfig($config);
        $defaults = [
            'baseUrl' => 'https://app.verifyonce.com/api/verify/',
        ];
        $this->config = array_merge($defaults, $config);
    }

    /**
     * Make sure required parameters are provided.
     *
     * @param array $config
     * @throws InvalidConfigException
     */
    private function validateConfig(array $config)
    {
        $required = [
            'username',
            'password',
        ];
        foreach ($required as $key) {
            if (empty($config[$key])) {
                throw new InvalidConfigException("Missing required configuration parameter: $key");
            }
        }
    }

    /**
     * @return API
     */
    private function getApi(): API
    {
        if (!isset($this->api)) {
            $this->setApi(new API($this->config));
        }
        return $this->api;
    }

    /**
     * @param API $api
     */
    public function setApi(API $api): void
    {
        $this->api = $api;
    }
}
