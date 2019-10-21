<?php

namespace Ultraleet\VerifyOnce\Data;

/**
 * Class InitiateResponse
 *
 * @package ultraleet/verify-once
 *
 * @property-read string $transactionId
 * @property-read string $url
 */
class InitiateResponse extends AbstractData
{
    protected $transactionId;
    protected $url;

    /**
     * Set required field names.
     *
     * @return array
     */
    protected function required(): array
    {
        return [
            'transactionId',
            'url',
        ];
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     */
    public function setTransactionId(string $transactionId): void
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
