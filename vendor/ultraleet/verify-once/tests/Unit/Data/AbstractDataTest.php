<?php

namespace Tests\Unit\Data;

use stdClass;
use TypeError;
use Tests\TestCase;
use Ultraleet\VerifyOnce\Data\AbstractData;
use Ultraleet\VerifyOnce\Exceptions\UndefinedFieldException;
use Ultraleet\VerifyOnce\Exceptions\MissingRequiredFieldException;

class AbstractDataTest extends TestCase
{
    public function testInstantiateWithValidData()
    {
        $object = new TestData([
            'getterSetterField' => 'test',
            'regularField' => 'test',
        ]);
        $this->assertInstanceOf(TestData::class, $object);
    }

    public function testInstantiateWithNonExistentField()
    {
        $this->expectException(UndefinedFieldException::class);
        $object = new TestData([
            'invalidField' => 'test',
        ]);
    }

    public function testInstantiateWithInvalidFieldType()
    {
        $this->expectException(TypeError::class);
        $object = new TestData([
            'getterSetterField' => ['invalidType'],
        ]);
    }

    public function testInstantiateWithObject()
    {
        $object = new stdClass();
        $object->regularField = 'test';
        $testData = new TestData($object);

        $this->assertSame('test', $testData->regularField);
    }

    public function testGetterSetterWithValidField()
    {
        $object = new TestData();

        $object->getterSetterField = 'test';
        $this->assertSame('test', $object->getterSetterField);
    }

    public function testSetterWithInvalidFieldName()
    {
        $object = new TestData();

        $this->expectException(UndefinedFieldException::class);
        $object->nonExistentField = 'test';
    }

    public function testSetterWithInvalidFieldType()
    {
        $object = new TestData();

        $this->expectException(TypeError::class);
        $object->getterSetterField = ['invalidType'];
    }

    public function testMutatingSetter()
    {
        $object = new TestData();

        $object->mutatingField = 'test';
        $this->assertSame('testMutated', $object->mutatingField);
    }

    public function testSettingAndGettingRegularField()
    {
        $object = new TestData();

        $object->regularField = 'test';
        $this->assertSame('test', $object->regularField);
    }

    public function testToArray()
    {
        $array = [
            'getterSetterField' => 'test',
            'mutatingField' => 'test',
            'regularField' => 'test',
        ];
        $object = new TestData($array);

        $array['mutatingField'] .= 'Mutated';
        $this->assertSame($array, $object->toArray());
    }

    public function testRequiredField()
    {
        $this->expectException(MissingRequiredFieldException::class);
        (new TestData())->validate();
    }
}

/**
 * Class TestData
 *
 * @property $getterSetterField
 * @property $mutatingField
 * @property $regularField
 */
class TestData extends AbstractData
{
    protected $getterSetterField;
    protected $mutatingField;
    protected $regularField;

    /**
     * Set required field names.
     *
     * @return array
     */
    protected function required(): array
    {
        return ['regularField'];
    }

    /**
     * @return mixed
     */
    public function getGetterSetterField(): string
    {
        return $this->getterSetterField ;
    }

    /**
     * @param mixed $getterSetterField
     */
    public function setGetterSetterField(string $getterSetterField): void
    {
        $this->getterSetterField = $getterSetterField;
    }

    /**
     * @return mixed
     */
    public function getMutatingField()
    {
        return $this->mutatingField;
    }

    /**
     * @param mixed $mutatingField
     */
    public function setMutatingField($mutatingField): void
    {
        $this->mutatingField = $mutatingField . 'Mutated';
    }
}
