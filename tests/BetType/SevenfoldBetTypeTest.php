<?php

use BettingCalculator\Calculator;
use BettingCalculator\Selection;
use BettingCalculator\BetType\SevenfoldBetType;

class SevenfoldBetTypeTest extends PHPUnit_Framework_TestCase
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
    
    public function testBetTypeSevenfold()
    {
        $betType = new SevenfoldBetType();
        $this->assertSame("Sevenfold", $betType->name());
        $this->assertSame(7, $betType->totalSelections());
        $this->assertSame(1, $betType->totalBets());
        $this->assertFalse($betType->withSingles());
        $this->assertFalse($betType->isAccumulated());
    }

    public function testBetTypeSevenfoldWithWonSelection()
    {
        $selection = new Selection("5/2", "won", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "won", "1/4");
        $selection5 = new Selection("4/11", "won", "1/4");
        $selection6 = new Selection("2/7", "won", "1/4");
        $selection7 = new Selection("7/2", "won", "1/4");
        $betType = new SevenfoldBetType();
        $calculator = new Calculator(0.50, false, [ $selection, $selection2, $selection3, $selection4, $selection5, $selection6, $selection7 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(0.50, $result['outlay']);
        $this->assertSame(497.05, $result['returns']);
        $this->assertSame(496.55, $result['profit']);
    }

    public function testBetTypeSevenfoldWithPlacedSelection()
    {
        $selection = new Selection("5/2", "placed", "1/4");
        $selection2 = new Selection("6/4", "placed", "1/4");
        $selection3 = new Selection("3/1", "placed", "1/4");
        $selection4 = new Selection("13/5", "placed", "1/4");
        $selection5 = new Selection("4/11", "placed", "1/4");
        $selection6 = new Selection("2/7", "placed", "1/4");
        $selection7 = new Selection("7/2", "won", "1/4");
        $betType = new SevenfoldBetType();
        $calculator = new Calculator(0.50, false, [ $selection, $selection2, $selection3, $selection4, $selection5, $selection6, $selection7 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(0.50, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-0.50, $result['profit']);
    }

    public function testBetTypeSevenfoldWithLostSelection()
    {
        $selection = new Selection("5/2", "lost", "1/4");
        $selection2 = new Selection("6/4", "lost", "1/4");
        $selection3 = new Selection("3/1", "lost", "1/4");
        $selection4 = new Selection("13/5", "lost", "1/4");
        $selection5 = new Selection("4/11", "lost", "1/4");
        $selection6 = new Selection("2/7", "lost", "1/4");
        $selection7 = new Selection("7/2", "won", "1/4");
        $betType = new SevenfoldBetType();
        $calculator = new Calculator(0.50, false, [ $selection, $selection2, $selection3, $selection4, $selection5, $selection6, $selection7 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(0.50, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-0.50, $result['profit']);
    }

    public function testBetTypeSevenfoldWithVoidSelection()
    {
        $selection = new Selection("5/2", "void", "1/4");
        $selection2 = new Selection("6/4", "void", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "void", "1/4");
        $selection5 = new Selection("4/11", "won", "1/4");
        $selection6 = new Selection("2/7", "won", "1/4");
        $selection7 = new Selection("7/2", "won", "1/4");
        $betType = new SevenfoldBetType();
        $calculator = new Calculator(0.50, false, [ $selection, $selection2, $selection3, $selection4, $selection5, $selection6, $selection7 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(0.50, $result['outlay']);
        $this->assertSame(15.78, $result['returns']);
        $this->assertSame(15.28, $result['profit']);
    }
}
