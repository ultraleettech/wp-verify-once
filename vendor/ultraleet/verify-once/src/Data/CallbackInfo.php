<?php

namespace Ultraleet\VerifyOnce\Data;

/**
 * Class CallbackInfo
 *
 * @property-read Transaction $transaction;
 * @property-read User $user;
 * @property-read IdentityCallbackInfo $identityVerification;
 * @property-read AddressCallbackInfo $addressVerification;
 * @property-read int $iat
 */
class CallbackInfo extends AbstractData
{
    protected $transaction;
    protected $user;
    protected $identityVerification;
    protected $addressVerification;
    protected $iat;

    /**
     * Set required field names.
     *
     * @return array
     */
    protected function required(): array
    {
        return [

        ];
    }

    /**
     * @return Transaction
     */
    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    /**
     * @param array $transaction
     */
    public function setTransaction(array $transaction): void
    {
        $this->transaction = new Transaction($transaction);
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param array $user
     */
    public function setUser(array $user): void
    {
        $this->user = new User($user);
    }

    /**
     * @return IdentityCallbackInfo
     */
    public function getIdentityVerification()
    {
        return $this->identityVerification;
    }

    /**
     * @param array $identityVerification
     */
    public function setIdentityVerification($identityVerification): void
    {
        $this->identityVerification = $identityVerification ? new IdentityCallbackInfo($identityVerification) : null;
    }

    /**
     * @return AddressCallbackInfo
     */
    public function getAddressVerification()
    {
        return $this->addressVerification;
    }

    /**
     * @param array $addressVerification
     */
    public function setAddressVerification($addressVerification): void
    {
        $this->addressVerification = $addressVerification ? new AddressCallbackInfo($addressVerification) : null;
    }

}
