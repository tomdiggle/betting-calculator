<?php

use BettingCalculator\Calculator;
use BettingCalculator\Selection;
use BettingCalculator\BetType\FivefoldBetType;

class FivefoldBetTypeTest extends PHPUnit_Framework_TestCase
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
    
    public function testBetTypeFivefold()
    {
        $betType = new FivefoldBetType();
        $this->assertSame("Fivefold", $betType->name());
        $this->assertSame(5, $betType->totalSelections());
        $this->assertSame(1, $betType->totalBets());
        $this->assertFalse($betType->withSingles());
        $this->assertFalse($betType->isAccumulator());
    }

    public function testBetTypeFivefoldWithWonSelection()
    {
        $selection = new Selection("5/2", "won", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "won", "1/4");
        $selection5 = new Selection("4/11", "won", "1/4");
        $betType = new FivefoldBetType();
        $calculator = new Calculator(2.00, false, [ $selection, $selection2, $selection3, $selection4, $selection5 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(2.00, $result['outlay']);
        $this->assertSame(343.64, $result['returns']);
        $this->assertSame(341.64, $result['profit']);
    }

    public function testBetTypeFivefoldWithPlacedSelection()
    {
        $selection = new Selection("5/2", "placed", "1/4");
        $selection2 = new Selection("6/4", "placed", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "placed", "1/4");
        $selection5 = new Selection("4/11", "won", "1/4");
        $betType = new FivefoldBetType();
        $calculator = new Calculator(2.00, false, [ $selection, $selection2, $selection3, $selection4, $selection5 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(2.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-2.00, $result['profit']);
    }

    public function testBetTypeFivefoldWithLostSelection()
    {
        $selection = new Selection("5/2", "lost", "1/4");
        $selection2 = new Selection("6/4", "lost", "1/4");
        $selection3 = new Selection("3/1", "lost", "1/4");
        $selection4 = new Selection("13/5", "won", "1/4");
        $selection5 = new Selection("4/11", "won", "1/4");
        $betType = new FivefoldBetType();
        $calculator = new Calculator(2.00, false, [ $selection, $selection2, $selection3, $selection4, $selection5 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(2.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-2.00, $result['profit']);
    }

    public function testBetTypeFivefoldWithVoidSelection()
    {
        $selection = new Selection("5/2", "void", "1/4");
        $selection2 = new Selection("6/4", "void", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "void", "1/4");
        $selection5 = new Selection("4/11", "won", "1/4");
        $betType = new FivefoldBetType();
        $calculator = new Calculator(2.00, false, [ $selection, $selection2, $selection3, $selection4, $selection5 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(2.00, $result['outlay']);
        $this->assertSame(10.91, $result['returns']);
        $this->assertSame(8.91, $result['profit']);
    }
}
