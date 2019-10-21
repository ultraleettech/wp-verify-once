<?php

namespace Ultraleet\VerifyOnce\Data;

use MyCLabs\Enum\Enum;
use Ultraleet\VerifyOnce\Exceptions\UndefinedFieldException;
use Ultraleet\VerifyOnce\Exceptions\MissingRequiredFieldException;

/**
 * Class AbstractData
 *
 * Data object base class.
 *
 * @package ultraleet/verify-once
 */
abstract class AbstractData
{
    public function __construct($data = [])
    {
        foreach ((array) $data as $key => $value) {
            $this->__set($key, $value);
        }
        if (func_num_args()) {
            $this->validate();
        }
    }

    /**
     * Set required field names.
     *
     * @return array
     */
    abstract protected function required(): array;

    /**
     * Make sure all required fields are set.
     *
     * @throws MissingRequiredFieldException
     */
    public function validate()
    {
        foreach ($this->required() as $key) {
            if (! isset($this->$key)) {
                $class = basename(static::class);
                throw new MissingRequiredFieldException("Class $class is missing required field: $key");
            }
        }
    }

    public function __get(string $name)
    {
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }
        if (! property_exists($this, $name)) {
            $class = static::class;
            throw new UndefinedFieldException("Class '$class' doesn't have a field called '$name'.");
        }
        return $this->$name;
    }

    public function __set(string $name, $value)
    {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter)) {
            $this->$setter($value);
            return;
        }
        if (! property_exists($this, $name)) {
            $class = static::class;
            throw new UndefinedFieldException("Class '$class' doesn't have a field called '$name'.");
        }
        $this->$name = $value;
    }

    public function toArray(): array
    {
        $result = [];
        foreach (get_object_vars($this) as $key => $value) {
            if (is_subclass_of($value, AbstractData::class)) {
                /** @var AbstractData $value */
                $result[$key] = $value->toArray();
            } elseif (is_subclass_of($value, Enum::class)) {
                /** @var Enum $value */
                $result[$key] = $value->getValue();
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}
