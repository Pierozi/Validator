<?php

namespace Plab\Validator;

/**
 * Class Parameters
 * @package Plab\Validator
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
     * @param $parameters, must be Traversable
     * @throws \Exception
     */
    public function __construct($parameterClassName, $parameters)
    {
        if (false === is_array($parameters)
            && false === ($parameters instanceof \stdClass)
            && false === ($parameters instanceof \Traversable)
        ) {
            throw new \Exception('Parameters must be an array or traversable object');
        }

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

    const REPORT_GROUP_EXCEPTION = 100;
    const REPORT_NO_EXCEPTION = 101;

    /**
     * @return mixed
     */
    public function isValid($report = self::REPORT_GROUP_EXCEPTION)
    {
        $exceptions = null;

        foreach ($this->iterator as $parameter) {

            if (true === $parameter->isValid()) {
                continue;
            }

            if (self::REPORT_NO_EXCEPTION === $report) {
                return false;
            }

            $key = $parameter->key();

            if (self::REPORT_GROUP_EXCEPTION === $report) {

                if (null === $exceptions) {
                    $exceptions = new \Hoa\Exception\Group('Validation parameters of has fail.');
                }

                $exceptions[$key] = new \Hoa\Exception\Idle('Parameter %s are invalid', 0, $key);
            }
        }

        if (null === $exceptions) {
            return true;
        }

        $exceptions->send();
        throw $exceptions;
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
