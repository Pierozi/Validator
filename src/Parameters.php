<?php

namespace Plab\Parameter;

class Parameters implements Iterator
{
    protected $iterator = [];

    public function __construct(Iterator $parameters)
    {

        foreach ($parameters as $key => $value) {

            if ($value instanceof Parameter) {
                $this->iterator = $value;
                continue;
            }
            
            $this->iterator[] = new Parameter($key, $value);
        }
    }

    public function isValid()
    {
        foreach ($this->iterator as $parameter) {
            //TODO we dont need stop if we want group hoa exception
        }
    }

    public function values()
    {
        $result = [];

        foreach ($this->iterator as $parameter) {
            $result[$parameter->key()] = $parameter->value();
        }

        return $result;
    }
}
