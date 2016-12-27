<?php

use BettingCalculator\Calculator;
use BettingCalculator\Selection;
use BettingCalculator\BetType\DoubleBetType;

class DoubleBetTypeTest extends PHPUnit_Framework_TestCase
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
    
    public function testBetTypeDouble()
    {
        $betType = new DoubleBetType();
        $this->assertSame("Double", $betType->name());
        $this->assertSame(2, $betType->totalSelections());
        $this->assertSame(1, $betType->totalBets());
        $this->assertFalse($betType->withSingles());
        $this->assertFalse($betType->isAccumulated());
    }

    public function testBetTypeDoubleWithWonSelection()
    {
        $selection = new Selection("5/2", "won", "1/4");
        $selection2 = new Selection("14/1", "won", "1/4");
        $betType = new DoubleBetType();
        $calculator = new Calculator(6.00, false, [ $selection, $selection2 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(6.00, $result['outlay']);
        $this->assertSame(315.00, $result['returns']);
        $this->assertSame(309.00, $result['profit']);
    }

    public function testBetTypeDoubleWithPlacedSelection()
    {
        $selection = new Selection("5/2", "placed", "1/4");
        $selection2 = new Selection("14/1", "won", "1/4");
        $betType = new DoubleBetType();
        $calculator = new Calculator(6.00, false, [ $selection, $selection2 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(6.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-6.00, $result['profit']);
    }

    public function testBetTypeDoubleWithLostSelection()
    {
        $selection = new Selection("5/2", "lost", "1/4");
        $selection2 = new Selection("14/1", "won", "1/4");
        $betType = new DoubleBetType();
        $calculator = new Calculator(6.00, false, [ $selection, $selection2 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(6.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-6.00, $result['profit']);
    }

    public function testBetTypeDoubleWithVoidSelection()
    {
        $selection = new Selection("5/2", "void", "1/4");
        $selection2 = new Selection("14/1", "won", "1/4");
        $betType = new DoubleBetType();
        $calculator = new Calculator(6.00, false, [ $selection, $selection2 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(6.00, $result['outlay']);
        $this->assertSame(90.00, $result['returns']);
        $this->assertSame(84.00, $result['profit']);
    }
}
