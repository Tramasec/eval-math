<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2019
 * @license BSD 2.0
 */

namespace Webit\Util\EvalMath\Tests;

use PHPUnit\Framework\TestCase;
use SergeR\Util\EvalMath\EvalMath;
use SergeR\Util\EvalMath\Exception\AbstractEvalMathException;
use SergeR\Util\EvalMath\Exception\BuiltInFunctionRedefinitionException;
use SergeR\Util\EvalMath\Exception\ConstantAssignmentException;
use SergeR\Util\EvalMath\Exception\DivisionByZeroException;
use SergeR\Util\EvalMath\Exception\ExpectingTokenException;
use SergeR\Util\EvalMath\Exception\IllegalCharacterException;
use SergeR\Util\EvalMath\Exception\InternalErrorException;
use SergeR\Util\EvalMath\Exception\InvalidArgumentCountException;
use SergeR\Util\EvalMath\Exception\OperatorLacksOperandException;
use SergeR\Util\EvalMath\Exception\OperatorRequiredException;
use SergeR\Util\EvalMath\Exception\UndefinedVariableException;
use SergeR\Util\EvalMath\Exception\UndefinedVariableInFunctionDefinitionException;
use SergeR\Util\EvalMath\Exception\UnexpectedOperatorException;
use SergeR\Util\EvalMath\Exception\UnexpectedTokenException;

class EvalMathExceptionsTest extends TestCase
{
    private $EvalMath;

    protected function setUp()
    {
        $this->EvalMath = new EvalMath();
    }

    /**
     * @throws AbstractEvalMathException
     */
    public function testBuiltInFunctionRedefinition()
    {
        $this->expectException(BuiltInFunctionRedefinitionException::class);
        $this->EvalMath->evaluate('cos(x) = x*2');
    }

    /**
     * @throws AbstractEvalMathException
     */
    public function testConstantAssignmentException()
    {
        $this->expectException(ConstantAssignmentException::class);
        $this->EvalMath->evaluate('pi = 123');
    }

    /**
     * @throws AbstractEvalMathException
     */
    public function testDivisionByZero()
    {
        $this->expectException(DivisionByZeroException::class);
        $this->EvalMath->evaluate('5/0');
    }

    /**
     * @throws AbstractEvalMathException
     */
    public function testExpectingTokenException()
    {
        $this->expectException(ExpectingTokenException::class);
        $this->EvalMath->evaluate('p = 6*(3+1');
    }

    /**
     * @throws AbstractEvalMathException
     */
    public function testIllegalCharacterException()
    {
        $this->expectException(IllegalCharacterException::class);
        $this->EvalMath->evaluate('$v = 5');
    }

    /**
     * @throws AbstractEvalMathException
     */
    public function testInternalErrorException()
    {
        $this->expectException(InternalErrorException::class);
        $this->EvalMath->e('k=');
    }

    /**
     * @throws AbstractEvalMathException
     */
    public function testInvalidArgumentCountException()
    {
        $this->expectException(InvalidArgumentCountException::class);
        $this->EvalMath->e('a=sin(5,7,6)');
    }

    /**
     * @throws AbstractEvalMathException
     */
    public function testOperatorLacksOperandException()
    {
        $this->expectException(OperatorLacksOperandException::class);
        $this->EvalMath->e('k=5+');
    }

    /**
     * @throws AbstractEvalMathException
     */
    public function testOperatorRequiredException()
    {
        $this->expectException(OperatorRequiredException::class);
        $this->EvalMath->e('a=5(7+1)');
    }

    /**
     * @throws AbstractEvalMathException
     */
    public function testUndefinedVariableException()
    {
        $this->expectException(UndefinedVariableException::class);
        $this->EvalMath->e('b=a+1');
    }

    /**
     * @throws AbstractEvalMathException
     */
    public function testUndefinedVariableInFunctionDefinitionException()
    {
        $this->expectException(UndefinedVariableInFunctionDefinitionException::class);
        $this->EvalMath->e('f(a) = b*3');
    }

    /**
     * @throws AbstractEvalMathException
     */
    public function testUnexpectedOperatorException()
    {
        $this->expectException(UnexpectedOperatorException::class);
        $this->EvalMath->e('1 + * 2');
    }

    /**
     * @throws AbstractEvalMathException
     */
    public function testUnexpectedTokenException()
    {
        $this->expectException(UnexpectedTokenException::class);
        $this->EvalMath->e('a=(3+)');
    }
}