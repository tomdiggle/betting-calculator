<?php

use BettingCalculator\Calculator;
use BettingCalculator\Selection;
use BettingCalculator\BetType\Lucky31BetType;

class Lucky31BetTypeTest extends PHPUnit_Framework_TestCase
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
    
    public function testBetTypeLucky31()
    {
        $betType = new Lucky31BetType();
        $this->assertSame("Lucky 31", $betType->name());
        $this->assertSame(5, $betType->totalSelections());
        $this->assertSame(31, $betType->totalBets());
        $this->assertTrue($betType->withSingles());
        $this->assertTrue($betType->isAccumulated());
    }

    public function testBetTypeLucky31WithWonSelection()
    {
        $selection = new Selection("5/2", "won", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "won", "1/4");
        $selection5 = new Selection("4/11", "won", "1/4");
        $betType = new Lucky31BetType();
        $calculator = new Calculator(1.00, false, [ $selection, $selection2, $selection3, $selection4, $selection5 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(31.00, $result['outlay']);
        $this->assertSame(855.23, $result['returns']);
        $this->assertSame(824.23, $result['profit']);
    }

    public function testBetTypeLucky31WithPlacedSelection()
    {
        $selection = new Selection("5/2", "placed", "1/4");
        $selection2 = new Selection("6/4", "placed", "1/4");
        $selection3 = new Selection("3/1", "placed", "1/4");
        $selection4 = new Selection("13/5", "placed", "1/4");
        $selection5 = new Selection("4/11", "placed", "1/4");
        $betType = new Lucky31BetType();
        $calculator = new Calculator(1.00, false, [ $selection, $selection2, $selection3, $selection4, $selection5 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(31.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-31.00, $result['profit']);
    }

    public function testBetTypeLucky31WithLostSelection()
    {
        $selection = new Selection("5/2", "lost", "1/4");
        $selection2 = new Selection("6/4", "lost", "1/4");
        $selection3 = new Selection("3/1", "lost", "1/4");
        $selection4 = new Selection("13/5", "lost", "1/4");
        $selection5 = new Selection("4/11", "lost", "1/4");
        $betType = new Lucky31BetType();
        $calculator = new Calculator(1.00, false, [ $selection, $selection2, $selection3, $selection4, $selection5 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(31.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-31.00, $result['profit']);
    }

    public function testBetTypeLucky31WithVoidSelection()
    {
        $selection = new Selection("5/2", "void", "1/4");
        $selection2 = new Selection("6/4", "void", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "void", "1/4");
        $selection5 = new Selection("4/11", "won", "1/4");
        $betType = new Lucky31BetType();
        $calculator = new Calculator(1.00, false, [ $selection, $selection2, $selection3, $selection4, $selection5 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(31.00, $result['outlay']);
        $this->assertSame(93.55, $result['returns']);
        $this->assertSame(62.55, $result['profit']);
    }
}
