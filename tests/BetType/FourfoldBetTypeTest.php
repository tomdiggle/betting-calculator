<?php

use BettingCalculator\Calculator;
use BettingCalculator\Selection;
use BettingCalculator\BetType\FourfoldBetType;

class FourfoldBetTypeTest extends PHPUnit_Framework_TestCase
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
    
    public function testBetTypeFourfold()
    {
        $betType = new FourfoldBetType();
        $this->assertSame("Fourfold", $betType->name());
        $this->assertSame(4, $betType->totalSelections());
        $this->assertSame(1, $betType->totalBets());
        $this->assertFalse($betType->withSingles());
        $this->assertFalse($betType->isAccumulated());
    }

    public function testBetTypeFourfoldWithWonSelection()
    {
        $selection = new Selection("5/2", "won", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "won", "1/4");
        $betType = new FourfoldBetType();
        $calculator = new Calculator(1.00, false, [ $selection, $selection2, $selection3, $selection4 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(1.00, $result['outlay']);
        $this->assertSame(126.00, $result['returns']);
        $this->assertSame(125.00, $result['profit']);
    }

    public function testBetTypeFourfoldWithPlacedSelection()
    {
        $selection = new Selection("5/2", "placed", "1/4");
        $selection2 = new Selection("6/4", "placed", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "placed", "1/4");
        $betType = new FourfoldBetType();
        $calculator = new Calculator(1.00, false, [ $selection, $selection2, $selection3, $selection4 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(1.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-1.00, $result['profit']);
    }

    public function testBetTypeFourfoldWithLostSelection()
    {
        $selection = new Selection("5/2", "lost", "1/4");
        $selection2 = new Selection("6/4", "lost", "1/4");
        $selection3 = new Selection("3/1", "lost", "1/4");
        $selection4 = new Selection("13/5", "won", "1/4");
        $betType = new FourfoldBetType();
        $calculator = new Calculator(1.00, false, [ $selection, $selection2, $selection3, $selection4 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(1.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-1.00, $result['profit']);
    }

    public function testBetTypeFourfoldWithVoidSelection()
    {
        $selection = new Selection("5/2", "void", "1/4");
        $selection2 = new Selection("6/4", "void", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "void", "1/4");
        $betType = new FourfoldBetType();
        $calculator = new Calculator(1.00, false, [ $selection, $selection2, $selection3, $selection4 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(1.00, $result['outlay']);
        $this->assertSame(4.00, $result['returns']);
        $this->assertSame(3.00, $result['profit']);
    }
}
