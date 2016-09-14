<?php

namespace Plab\Parameter;

abstract class Parameter
{
    protected $key;
    protected $value;

    /**
     * Map assertions callback, must be pure method
     * @param $key
     * @return string
     */
    abstract protected function mapAssertion($key) : string;

    /**
     * Return true if parameter must be readonly and not edited from user space
     * @param $key
     * @return bool
     */
    abstract protected function isReadOnly($key) : boolean;

    /**
     * Map converter callback, must be pure method
     * @param $key
     * @return string
     */
    abstract protected function mapConverter($key) : string;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function isValid()
    {
        $checker = $this->mapAssertion($this->key);

        if (null === $checker) {
            //TODO assertion missing for this parameter
        }
    }

    public function value()
    {
        $conveter = $this->mapConverter($this->key);

        if (null === $converter) {
            return $this->value;
        }

        //TODO call converter
    }
}
