<?php

namespace Plab\Parameter;

/**
 * Class Parameters
 * @package Plab\Parameter
 */
class Parameters implements \Iterator, \Countable
{
    /**
     * @var \ArrayIterator
     */
    protected $iterator;

    /**
     * Parameters constructor.
     * @param $parameterClassName
     * @param array $parameters
     * @throws \Exception
     */
    public function __construct($parameterClassName, Array $parameters)
    {
        $this->iterator = new \ArrayIterator();

        foreach ($parameters as $key => $value) {

            if ($value instanceof Parameter) {

                $this->iterator[] = $value;
                continue;
            }

            $parameter = new $parameterClassName($key, $value);

            if (!($parameter instanceof Parameter)) {
                throw new \Exception('class provide must child of ' . Parameter::class);
            }

            $this->iterator[] = $parameter;
        }
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        foreach ($this->iterator as $parameter) {

            if (false === $parameter->isValid()) {

                //TODO we should not stop iteration if we want group hoa exception
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public function values()
    {
        $result = [];

        foreach ($this->iterator as $parameter) {
            $result[$parameter->key()] = $parameter->value();
        }

        return $result;
    }

    public function next()
    {
        $this->iterator->next();
    }

    public function valid()
    {
        return $this->iterator->valid();
    }

    public function current()
    {
        return $this->iterator->current();
    }

    public function rewind()
    {
        $this->iterator->rewind();
    }

    public function key()
    {
        return $this->iterator->key();
    }

    public function count()
    {
        return $this->iterator->count();
    }
}