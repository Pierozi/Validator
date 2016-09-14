<?php

namespace Checker {
trait Scalar {
    function isString() {
    }
}
}

namespace {

class Parameter
{
    use Checker\Scalar;
}


$phone = new Parameter('phone', '0648099915');


if ('0648099915' === $Parameter->value()) {
    echo '1';
}

if (true === $Parameter->isValid()) {
    echo '2';
}

$Parameters = new Parameters(['name' => 'pierre', 'phone', '0648099915']);

true === $Parameters->isValid();
//[...] === $Parameters->values();

}
