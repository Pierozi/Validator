<?php

declare(strict_types=1);
namespace Plab\Validator;

/**
 * Class Parameters
 * @package Plab\Validator
 */
class Parameters implements \Iterator, \Countable
{
    const REPORT_GROUP_EXCEPTION = 100;
    const REPORT_NO_EXCEPTION = 101;

    /**
     * @var \ArrayIterator
     */
    protected $iterator;

    /**
     * Parameters constructor.
     * @param string $parameterClassName
     * @param \Traversable $parameters, must be Traversable
     * @throws \Exception
     */
    public function __construct(string $parameterClassName, \Traversable $parameters)
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
     * @param int $report
     * @return bool
     * @throws \Hoa\Exception\Group
     */
    public function isValid(int $report = self::REPORT_GROUP_EXCEPTION): bool
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

    public function count(): int
    {
        return $this->iterator->count();
    }
}
