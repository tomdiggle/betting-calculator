<?php

use BettingCalculator\Calculator;
use BettingCalculator\Selection;
use BettingCalculator\BetType\SixfoldBetType;

class SixfoldBetTypeTest extends PHPUnit_Framework_TestCase
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
    
    public function testBetTypeSixfold()
    {
        $betType = new SixfoldBetType();
        $this->assertSame("Sixfold", $betType->name());
        $this->assertSame(6, $betType->totalSelections());
        $this->assertSame(1, $betType->totalBets());
        $this->assertFalse($betType->withSingles());
        $this->assertFalse($betType->isAccumulator());
    }

    public function testBetTypeSixfoldWithWonSelection()
    {
        $selection = new Selection("5/2", "won", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "won", "1/4");
        $selection5 = new Selection("4/11", "won", "1/4");
        $selection6 = new Selection("2/7", "won", "1/4");
        $betType = new SixfoldBetType();
        $calculator = new Calculator(5.00, false, [ $selection, $selection2, $selection3, $selection4, $selection5, $selection6 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(5.00, $result['outlay']);
        $this->assertSame(1104.55, $result['returns']);
        $this->assertSame(1099.55, $result['profit']);
    }

    public function testBetTypeSixfoldWithPlacedSelection()
    {
        $selection = new Selection("5/2", "placed", "1/4");
        $selection2 = new Selection("6/4", "placed", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "placed", "1/4");
        $selection5 = new Selection("4/11", "won", "1/4");
        $selection6 = new Selection("2/7", "won", "1/4");
        $betType = new SixfoldBetType();
        $calculator = new Calculator(5.00, false, [ $selection, $selection2, $selection3, $selection4, $selection5, $selection6 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(5.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-5.00, $result['profit']);
    }

    public function testBetTypeSixfoldWithLostSelection()
    {
        $selection = new Selection("5/2", "lost", "1/4");
        $selection2 = new Selection("6/4", "lost", "1/4");
        $selection3 = new Selection("3/1", "lost", "1/4");
        $selection4 = new Selection("13/5", "won", "1/4");
        $selection5 = new Selection("4/11", "won", "1/4");
        $selection6 = new Selection("2/7", "won", "1/4");
        $betType = new SixfoldBetType();
        $calculator = new Calculator(5.00, false, [ $selection, $selection2, $selection3, $selection4, $selection5, $selection6 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(5.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-5.00, $result['profit']);
    }

    public function testBetTypeSixfoldWithVoidSelection()
    {
        $selection = new Selection("5/2", "void", "1/4");
        $selection2 = new Selection("6/4", "void", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "void", "1/4");
        $selection5 = new Selection("4/11", "won", "1/4");
        $selection6 = new Selection("2/7", "won", "1/4");
        $betType = new SixfoldBetType();
        $calculator = new Calculator(5.00, false, [ $selection, $selection2, $selection3, $selection4, $selection5, $selection6 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(5.00, $result['outlay']);
        $this->assertSame(35.06, $result['returns']);
        $this->assertSame(30.06, $result['profit']);
    }
}
