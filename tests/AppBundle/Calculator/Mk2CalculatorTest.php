<?php

namespace Tests\AppBundle\Calculator;

use AppBundle\Calculator\CalculatorInterface;
use AppBundle\Model\Change;
use AppBundle\Calculator\Mk2Calculator;
use PHPUnit\Framework\TestCase;

class Mk2CalculatorTest extends TestCase
{
    /**
     * @var CalculatorInterface
     */
    private $calculator;

    protected function setUp()
    {
        $this->calculator = new Mk2Calculator();
    }

    public function testGetSupportedModel()
    {
        $this->assertEquals('mk2', $this->calculator->getSupportedModel());
    }

    public function testGetChangeEasy()
    {
        $change = $this->calculator->getChange(2);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(1, $change->coin2);
    }
    public function testGetChangeHard()
    {
        $change = $this->calculator->getChange(17);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(1, $change->coin2);
        $this->assertEquals(1, $change->bill10);
        $this->assertEquals(1, $change->bill5);
    }
    public function testGetChangeVeryHard()
    {
        $change = $this->calculator->getChange(117);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(1, $change->coin2);
        $this->assertEquals(11, $change->bill10);
        $this->assertEquals(1, $change->bill5);
    }
    public function testpossibleChangeHard()
    {
        $change = $this->calculator->getChange(83);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(4, $change->coin2);
        $this->assertEquals(7, $change->bill10);
        $this->assertEquals(1, $change->bill5);
    }
    public function testImpossibleChangeHardExtrem()
    {
        $change = $this->calculator->getChange(1005);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(0, $change->coin2);
        $this->assertEquals(100, $change->bill10);
        $this->assertEquals(1, $change->bill5);
    }

    public function testGetChangeImpossible()
    {
        $change = $this->calculator->getChange(1);
        $this->assertNull($change);
    }
}