<?php

use BettingCalculator\Calculator;
use BettingCalculator\Selection;
use BettingCalculator\BetType\Lucky63BetType;

class Lucky63BetTypeTest extends PHPUnit_Framework_TestCase
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
    
    public function testBetTypeLucky63()
    {
        $betType = new Lucky63BetType();
        $this->assertSame("Lucky 63", $betType->name());
        $this->assertSame(6, $betType->totalSelections());
        $this->assertSame(63, $betType->totalBets());
        $this->assertTrue($betType->withSingles());
        $this->assertTrue($betType->isAccumulated());
    }

    public function testBetTypeLucky63WithWonSelection()
    {
        $selection = new Selection("5/2", "won", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "won", "1/4");
        $selection5 = new Selection("4/11", "won", "1/4");
        $selection6 = new Selection("2/7", "won", "1/4");
        $betType = new Lucky63BetType();
        $calculator = new Calculator(0.10, false, [ $selection, $selection2, $selection3, $selection4, $selection5, $selection6 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(6.30, $result['outlay']);
        $this->assertSame(195.61, $result['returns']);
        $this->assertSame(189.31, $result['profit']);
    }

    public function testBetTypeLucky63WithPlacedSelection()
    {
        $selection = new Selection("5/2", "placed", "1/4");
        $selection2 = new Selection("6/4", "placed", "1/4");
        $selection3 = new Selection("3/1", "placed", "1/4");
        $selection4 = new Selection("13/5", "placed", "1/4");
        $selection5 = new Selection("4/11", "placed", "1/4");
        $selection6 = new Selection("2/7", "placed", "1/4");
        $betType = new Lucky63BetType();
        $calculator = new Calculator(0.10, false, [ $selection, $selection2, $selection3, $selection4, $selection5, $selection6 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(6.30, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-6.30, $result['profit']);
    }

    public function testBetTypeLucky63WithLostSelection()
    {
        $selection = new Selection("5/2", "lost", "1/4");
        $selection2 = new Selection("6/4", "lost", "1/4");
        $selection3 = new Selection("3/1", "lost", "1/4");
        $selection4 = new Selection("13/5", "lost", "1/4");
        $selection5 = new Selection("4/11", "lost", "1/4");
        $selection6 = new Selection("2/7", "lost", "1/4");
        $betType = new Lucky63BetType();
        $calculator = new Calculator(0.10, false, [ $selection, $selection2, $selection3, $selection4, $selection5, $selection6 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(6.30, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-6.30, $result['profit']);
    }

    public function testBetTypeLucky63WithVoidSelection()
    {
        $selection = new Selection("5/2", "void", "1/4");
        $selection2 = new Selection("6/4", "void", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "void", "1/4");
        $selection5 = new Selection("4/11", "won", "1/4");
        $selection6 = new Selection("2/7", "won", "1/4");
        $betType = new Lucky63BetType();
        $calculator = new Calculator(0.10, false, [ $selection, $selection2, $selection3, $selection4, $selection5, $selection6 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(6.30, $result['outlay']);
        $this->assertSame(21.51, $result['returns']);
        $this->assertSame(15.21, $result['profit']);
    }
}
