<?php

namespace Ultraleet\VerifyOnce\Data;

use Ultraleet\VerifyOnce\Types\CountryCode;
use Ultraleet\VerifyOnce\Types\VerificationStatus;
use Ultraleet\VerifyOnce\Exceptions\InvalidValueException;

/**
 * Class AddressCallbackInfo
 *
 * @package ultraleet/verify-once
 *
 * @property-read string $id
 * @property-read string $userId
 * @property-read string $transactionId
 * @property-read CountryCode $countryCode
 * @property-read string $city
 * @property-read string $state
 * @property-read string $postalCode
 * @property-read string $address
 * @property-read VerificationStatus $status
 * @property-read string $createdDate
 * @property-read string $updatedDate
 *
 * @todo Convert datetime fields
 */
class AddressCallbackInfo extends AbstractData
{
    protected $id;
    protected $userId;
    protected $transactionId;
    protected $countryCode;
    protected $city;
    protected $state;
    protected $postalCode;
    protected $address;
    protected $status;
    protected $createdDate;
    protected $updatedDate;

    /**
     * Set required field names.
     *
     * @return array
     */
    protected function required(): array
    {
        return [
            'id',
            'userId',
            'transactionId',
            'countryCode',
            'city',
            'address',
            'status',
        ];
    }

    /**
     * @return CountryCode
     */
    public function getCountryCode(): CountryCode
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode): void
    {
        if (! $countryCode) {
            throw new InvalidValueException('countryCode');
        }
        $this->countryCode = CountryCode::$countryCode();
    }

    /**
     * @return VerificationStatus
     */
    public function getStatus(): VerificationStatus
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        if (! $status) {
            throw new InvalidValueException('status');
        }
        $this->status = VerificationStatus::$status();
    }
}
