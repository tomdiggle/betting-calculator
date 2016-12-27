<?php

use BettingCalculator\Calculator;
use BettingCalculator\Selection;
use BettingCalculator\BetType\TrebleBetType;

class TrebleBetTypeTest extends PHPUnit_Framework_TestCase
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
    
    public function testBetTypeTreble()
    {
        $betType = new TrebleBetType();
        $this->assertSame("Treble", $betType->name());
        $this->assertSame(3, $betType->totalSelections());
        $this->assertSame(1, $betType->totalBets());
        $this->assertFalse($betType->withSingles());
        $this->assertFalse($betType->isAccumulated());
    }

    public function testBetTypeTrebleWithWonSelection()
    {
        $selection = new Selection("5/2", "won", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("7/1", "won", "1/4");
        $betType = new TrebleBetType();
        $calculator = new Calculator(3.25, false, [ $selection, $selection2, $selection3 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(3.25, $result['outlay']);
        $this->assertSame(227.50, $result['returns']);
        $this->assertSame(224.25, $result['profit']);
    }

    public function testBetTypeTrebleWithPlacedSelection()
    {
        $selection = new Selection("5/2", "placed", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("7/1", "won", "1/4");
        $betType = new TrebleBetType();
        $calculator = new Calculator(3.25, false, [ $selection, $selection2, $selection3 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(3.25, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-3.25, $result['profit']);
    }

    public function testBetTypeTrebleWithLostSelection()
    {
        $selection = new Selection("5/2", "lost", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("7/1", "won", "1/4");
        $betType = new TrebleBetType();
        $calculator = new Calculator(3.25, false, [ $selection, $selection2, $selection3 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(3.25, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-3.25, $result['profit']);
    }

    public function testBetTypeTrebleWithVoidSelection()
    {
        $selection = new Selection("5/2", "void", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("7/1", "won", "1/4");
        $betType = new TrebleBetType();
        $calculator = new Calculator(3.25, false, [ $selection, $selection2, $selection3 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(3.25, $result['outlay']);
        $this->assertSame(65.00, $result['returns']);
        $this->assertSame(61.75, $result['profit']);
    }
}
