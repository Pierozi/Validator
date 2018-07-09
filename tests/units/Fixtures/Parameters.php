<?php

namespace Plab\Validator\tests\unit;

use atoum\test;

class Parameters extends test
{
    public function test__construct()
    {
        $data = json_decode('{"city": "Lux"}');

        $this
            ->given(
                $this->newTestedInstance(\Plab\Validator\Fixtures\Parameter::class, $data),
                $result = $this->testedInstance->isValid()
            )
            ->variable($result)
            ->isEqualTo(true)
        ;
    }
}