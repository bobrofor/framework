<?php
/**
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/framework
 */

/**
 * @namespace
 */
namespace Bluz\Tests\Validator\Rule;

use \DateTime;
use Bluz\Tests;
use Bluz\Validator\Rule\Between;

/**
 * Class BetweenTest
 * @package Bluz\Tests\Validator\Rule
 */
class BetweenTest extends Tests\TestCase
{
    /**
     * @dataProvider providerForPass
     */
    public function testValuesBetweenBoundsShouldPass($min, $max, $inclusive, $input)
    {
        $validator = new Between($min, $max, $inclusive);
        $this->assertTrue($validator->validate($input));
        $this->assertTrue($validator->assert($input));
    }

    /**
     * @dataProvider providerForFail
     * @expectedException \Bluz\Validator\Exception\ValidatorException
     */
    public function testValuesOutBoundsShouldRaiseException($min, $max, $inclusive, $input)
    {
        $validator = new Between($min, $max, $inclusive);
        $this->assertFalse($validator->validate($input));
        $this->assertNotEmpty($validator->__toString());
        $this->assertFalse($validator->assert($input));
    }

    /**
     * @dataProvider providerForComponentException
     * @expectedException \Bluz\Validator\Exception\ComponentException
     */
    public function testInvalidConstructionParamsShouldRaiseException($min, $max)
    {
        new Between($min, $max);
    }

    /**
     * @return array
     */
    public function providerForPass()
    {
        return array(
            [0, 1, true, 0],
            [0, 1, true, 1],
            [10, 20, false, 15],
            [10, 20, true, 20],
            [-10, 20, false, -5],
            [-10, 20, false, 0],
            ['a', 'z', false, 'j'],
            array(
                new DateTime('yesterday'),
                new DateTime('tomorrow'),
                false,
                new DateTime('now')
            ),
        );
    }

    /**
     * @return array
     */
    public function providerForFail()
    {
        return array(
            [10, 20, true, ''],
            [10, 20, false, ''],
            [0, 1, false, 0],
            [0, 1, false, 1],
            [0, 1, false, 2],
            [0, 1, false, -1],
            [10, 20, false, 999],
            [10, 20, false, 20],
            [-10, 20, false, -11],
            ['a', 'j', false, 'z'],
            array(
                new DateTime('yesterday'),
                new DateTime('now'),
                false,
                new DateTime('tomorrow')
            ),
        );
    }

    /**
     * @return array
     */
    public function providerForComponentException()
    {
        return array(
            [10, 5],
            [10, null],
            [null, 5],
        );
    }
}
