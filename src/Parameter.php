<?php

namespace Plab\Parameter;

/**
 * Class Parameter
 * @package Plab\Parameter
 */
abstract class Parameter
{
    const checkersRules = [];
    const converters = [];

    protected $key;
    protected $value;

    use Checker\Scalar;
    use Converter\Scalar;
    use Operator\Scalar;

    //TODO implement constant for tolerance if checker missing ? throw notice, error, nothing

    /**
     * Parameter constructor.
     * @param $key
     * @param $value
     * @throws \Exception
     */
    public function __construct($key, $value)
    {
        $this->key   = $key;
        $this->value = $value;

        if (empty(static::checkersRules)) {
            throw new \Exception('You must implement constant checkersRules in ' . __CLASS__);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isValid()
    {
        $rule = static::checkersRules[$this->key] ?? null;

        if (null === $rule) {
            throw new \Exception('Checker rules not found', E_NOTICE);
        }

        $ruler   = new \Hoa\Ruler\Ruler();
        $context = new \Hoa\Ruler\Context();

        $context['key']   = $this->key;
        $context['value'] = $this->value;

        $checkerMethods   = $this->getMethods('is');
        $converterMethods = $this->getMethods('to');
        $operatorMethods  = $this->getMethods('op');

        $asserter = $ruler->getDefaultAsserter();

        foreach ($checkerMethods as $method) {
            $asserter->setOperator(mb_strtolower($method), xcallable($this, $method));
        }

        foreach ($converterMethods  as $method) {
            $asserter->setOperator(mb_strtolower($method), xcallable($this, $method));
        }

        foreach ($operatorMethods as $method) {
            $operatorName = mb_strtolower(substr($method, 2));
            $asserter->setOperator($operatorName, xcallable($this, $method));
        }

        return $ruler->assert($rule, $context);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function value()
    {
        $converter = static::converters[$this->key] ?? null;

        if (null === $converter) {
            return $this->value;
        }

        if (false === in_array(
                $converter,
                $this->getMethods('to')
            )) {
            throw new \Exception('Converter method not found', E_ERROR);
        }

        return (xcallable($this, $converter))($this->value);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * @param $lexeme
     * @return array
     */
    public function getMethods($lexeme)
    {
        $reflection = new \ReflectionClass($this);

        $methods = array_map(function($method) use($lexeme) {
            if ($lexeme === substr($method->name, 0, 2)) {
                return $method->name;
            }

            return null;
        }, $reflection->getMethods());

        return array_filter($methods, function($method) {
            return $method !== null;
        });
    }
}
