<?php

use BettingCalculator\Calculator;
use BettingCalculator\Selection;
use BettingCalculator\BetType\Lucky15BetType;

class Lucky15BetTypeTest extends PHPUnit_Framework_TestCase
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
    
    public function testBetTypeLucky15()
    {
        $betType = new Lucky15BetType();
        $this->assertSame("Lucky 15", $betType->name());
        $this->assertSame(4, $betType->totalSelections());
        $this->assertSame(15, $betType->totalBets());
        $this->assertTrue($betType->withSingles());
        $this->assertTrue($betType->isAccumulator());
    }

    public function testBetTypeLucky15WithWonSelection()
    {
        $selection = new Selection("5/2", "won", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "won", "1/4");
        $betType = new Lucky15BetType();
        $calculator = new Calculator(0.20, false, [ $selection, $selection2, $selection3, $selection4 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(3.00, $result['outlay']);
        $this->assertSame(72.25, $result['returns']);
        $this->assertSame(69.25, $result['profit']);
    }

    public function testBetTypeLucky15WithPlacedSelection()
    {
        $selection = new Selection("5/2", "placed", "1/4");
        $selection2 = new Selection("6/4", "placed", "1/4");
        $selection3 = new Selection("3/1", "placed", "1/4");
        $selection4 = new Selection("13/5", "placed", "1/4");
        $betType = new Lucky15BetType();
        $calculator = new Calculator(0.20, false, [ $selection, $selection2, $selection3, $selection4 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(3.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-3.00, $result['profit']);
    }

    public function testBetTypeLucky15WithLostSelection()
    {
        $selection = new Selection("5/2", "lost", "1/4");
        $selection2 = new Selection("6/4", "lost", "1/4");
        $selection3 = new Selection("3/1", "lost", "1/4");
        $selection4 = new Selection("13/5", "lost", "1/4");
        $betType = new Lucky15BetType();
        $calculator = new Calculator(0.20, false, [ $selection, $selection2, $selection3, $selection4 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(3.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-3.00, $result['profit']);
    }

    public function testBetTypeLucky15WithVoidSelection()
    {
        $selection = new Selection("5/2", "void", "1/4");
        $selection2 = new Selection("6/4", "void", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "void", "1/4");
        $betType = new Lucky15BetType();
        $calculator = new Calculator(0.20, false, [ $selection, $selection2, $selection3, $selection4 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(3.00, $result['outlay']);
        $this->assertSame(7.80, $result['returns']);
        $this->assertSame(4.80, $result['profit']);
    }
}
