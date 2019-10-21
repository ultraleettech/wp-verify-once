<?php

namespace Tests;

trait DefaultDataTrait
{
    protected $defaultTransactionData = [
        'id' => 'test',
        'integratorId' => 'test',
        'userId' => 'test',
        'createdDate' => 'test',
        'updatedDate' => 'test',
    ];

    protected $defaultUserData = [
        'id' => 'test',
        'email' => 'test',
        'role' => 'test',
        'scopes' => [],
        'status' => 'ACTIVE',
        'createdDate' => 'test',
        'updatedDate' => 'test',
    ];

    protected $defaultIdentityData = [
        'id' => 'test',
        'userId' => 'test',
        'transactionId' => 'test',
        'isManualReview' => false,
        'status' => 'FAILED',
        'idType' => 'PASSPORT',
        'rejectReason' => 'ID_INVALID_DATA',
    ];

    protected $defaultAddressData = [
        'id' => 'test',
        'userId' => 'test',
        'transactionId' => 'test',
        'countryCode' => 'EST',
        'city' => 'test',
        'address' => 'test',
        'status' => 'FAILED',
    ];

    protected function mergeData(array $data, string $name = '')
    {
        $property = "default{$name}Data";
        return array_merge($this->$property ?? [], $data);
    }
}
