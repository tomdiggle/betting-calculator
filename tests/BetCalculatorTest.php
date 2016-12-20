<?php

class BetCalculatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * PHPUnit setup routines
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }
    
    /**
     * PHPUnit tear down routines
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }
    
    public function testCalculatorWithZeroStakeReturnsZero()
    {
        $betType = new SingleBetType();
        $calculator = new BetCalculator(0, false, array(), $betType);
        $result = $calculator->calculate();

        $this->assertEmpty($result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertEmpty($result['profit']);
    }

    public function testCalculatorWithInvalidTotalSelections()
    {
        $betType = new SingleBetType();
        $calculator = new BetCalculator(20, false, array(), $betType);
        $result = $calculator->calculate();

        $this->assertEmpty($result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertEmpty($result['profit']);
    }
}
