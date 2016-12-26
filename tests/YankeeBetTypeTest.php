<?php

use BettingCalculator\Calculator;
use BettingCalculator\Selection;
use BettingCalculator\BetType\YankeeBetType;

class YankeeBetTypeTest extends PHPUnit_Framework_TestCase
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
    
    public function testBetTypeYankee()
    {
        $betType = new YankeeBetType();
        $this->assertSame("Yankee", $betType->name());
        $this->assertSame(4, $betType->totalSelections());
        $this->assertSame(11, $betType->totalBets());
        $this->assertFalse($betType->withSingles());
        $this->assertTrue($betType->isAccumulator());
    }

    public function testBetTypeYankeeWithWonSelection()
    {
        $selection = new Selection("5/2", "won", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "won", "1/4");
        $betType = new YankeeBetType();
        $calculator = new Calculator(0.25, false, [ $selection, $selection2, $selection3, $selection4 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(2.75, $result['outlay']);
        $this->assertSame(86.91, $result['returns']);
        $this->assertSame(84.16, $result['profit']);
    }

    public function testBetTypeYankeeWithPlacedSelection()
    {
        $selection = new Selection("5/2", "placed", "1/4");
        $selection2 = new Selection("6/4", "placed", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "placed", "1/4");
        $betType = new YankeeBetType();
        $calculator = new Calculator(0.25, false, [ $selection, $selection2, $selection3, $selection4 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(2.75, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-2.75, $result['profit']);
    }

    public function testBetTypeYankeeWithLostSelection()
    {
        $selection = new Selection("5/2", "lost", "1/4");
        $selection2 = new Selection("6/4", "lost", "1/4");
        $selection3 = new Selection("3/1", "lost", "1/4");
        $selection4 = new Selection("13/5", "won", "1/4");
        $betType = new YankeeBetType();
        $calculator = new Calculator(0.25, false, [ $selection, $selection2, $selection3, $selection4 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(2.75, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-2.75, $result['profit']);
    }

    public function testBetTypeYankeeWithVoidSelection()
    {
        $selection = new Selection("5/2", "void", "1/4");
        $selection2 = new Selection("6/4", "void", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $selection4 = new Selection("13/5", "void", "1/4");
        $betType = new YankeeBetType();
        $calculator = new Calculator(0.25, false, [ $selection, $selection2, $selection3, $selection4 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(2.75, $result['outlay']);
        $this->assertSame(8.00, $result['returns']);
        $this->assertSame(5.25, $result['profit']);
    }
}
