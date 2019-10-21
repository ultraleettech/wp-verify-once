<?php

namespace Ultraleet\VerifyOnce\Data;

/**
 * Class Transaction
 *
 * @package ultraleet/verify-once
 *
 * @property-read string $id
 * @property-read string $integratorId
 * @property-read string $userId
 * @property-read string $createdDate
 * @property-read string $updatedDate
 *
 * @todo Convert datetime fields
 */
class Transaction extends AbstractData
{
    protected $id;
    protected $integratorId;
    protected $userId;
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
            'integratorId',
            'userId',
            'createdDate',
            'updatedDate',
        ];
    }
}
