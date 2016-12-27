<?php

use BettingCalculator\Calculator;
use BettingCalculator\Selection;
use BettingCalculator\BetType\TrixieBetType;

class TrixieBetTypeTest extends PHPUnit_Framework_TestCase
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
    
    public function testBetTypeTrixie()
    {
        $betType = new TrixieBetType();
        $this->assertSame("Trixie", $betType->name());
        $this->assertSame(3, $betType->totalSelections());
        $this->assertSame(4, $betType->totalBets());
        $this->assertFalse($betType->withSingles());
        $this->assertTrue($betType->isAccumulated());
    }

    public function testBetTypeTrixieWithWonSelection()
    {
        $selection = new Selection("5/2", "won", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $betType = new TrixieBetType();
        $calculator = new Calculator(2.50, false, [ $selection, $selection2, $selection3 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(10.00, $result['outlay']);
        $this->assertSame(169.38, $result['returns']);
        $this->assertSame(159.38, $result['profit']);
    }

    public function testBetTypeTrixieWithPlacedSelection()
    {
        $selection = new Selection("5/2", "placed", "1/4");
        $selection2 = new Selection("6/4", "placed", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $betType = new TrixieBetType();
        $calculator = new Calculator(2.50, false, [ $selection, $selection2, $selection3 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(10.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-10.00, $result['profit']);
    }

    public function testBetTypeTrixieWithLostSelection()
    {
        $selection = new Selection("5/2", "lost", "1/4");
        $selection2 = new Selection("6/4", "lost", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $betType = new TrixieBetType();
        $calculator = new Calculator(2.50, false, [ $selection, $selection2, $selection3 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(10.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-10.00, $result['profit']);
    }

    public function testBetTypeTrixieWithVoidSelection()
    {
        $selection = new Selection("5/2", "void", "1/4");
        $selection2 = new Selection("6/4", "void", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $betType = new TrixieBetType();
        $calculator = new Calculator(2.50, false, [ $selection, $selection2, $selection3 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(10.00, $result['outlay']);
        $this->assertSame(32.50, $result['returns']);
        $this->assertSame(22.50, $result['profit']);
    }
}
