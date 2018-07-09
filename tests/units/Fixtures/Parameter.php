<?php

namespace Plab\Validator\tests\unit\Fixtures;

use atoum\test;

class Parameter extends test
{
    public function isIsValidProvider()
    {
        return [
            ['uuid', '', true],
            ['city', '', false],
            ['city', 42, false],
            ['city', null, false],
            ['city', 0x5, false],
            ['city', 'abcdefghijklmnoprstuvwxyzabcdefghijklmnoprstuvwxyz', false],
            ['city', 'Luxembourg', true],
        ];
    }

    /**
     * @dataProvider isIsValidProvider
     * @param $key
     * @param $value
     * @param $expected
     */
    public function testIsValid($key, $value, $expected)
    {
        $this
            ->given(
                $this->newTestedInstance($key, $value),
                $result = $this->testedInstance->isValid()
            )
            ->variable($result)
            ->isEqualTo($expected)
        ;
    }
}