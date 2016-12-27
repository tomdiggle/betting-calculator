<?php

use BettingCalculator\Calculator;
use BettingCalculator\Selection;
use BettingCalculator\BetType\PatentBetType;

class PatentBetTypeTest extends PHPUnit_Framework_TestCase
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
    
    public function testBetTypePatent()
    {
        $betType = new PatentBetType();
        $this->assertSame("Patent", $betType->name());
        $this->assertSame(3, $betType->totalSelections());
        $this->assertSame(7, $betType->totalBets());
        $this->assertTrue($betType->withSingles());
        $this->assertTrue($betType->isAccumulated());
    }

    public function testBetTypePatentWithWonSelection()
    {
        $selection = new Selection("5/2", "won", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $betType = new PatentBetType();
        $calculator = new Calculator(0.50, false, [ $selection, $selection2, $selection3 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(3.50, $result['outlay']);
        $this->assertSame(38.88, $result['returns']);
        $this->assertSame(35.38, $result['profit']);
    }

    public function testBetTypePatentWithPlacedSelection()
    {
        $selection = new Selection("5/2", "placed", "1/4");
        $selection2 = new Selection("6/4", "placed", "1/4");
        $selection3 = new Selection("3/1", "placed", "1/4");
        $betType = new PatentBetType();
        $calculator = new Calculator(0.50, false, [ $selection, $selection2, $selection3 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(3.50, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-3.50, $result['profit']);
    }

    public function testBetTypePatentWithLostSelection()
    {
        $selection = new Selection("5/2", "lost", "1/4");
        $selection2 = new Selection("6/4", "lost", "1/4");
        $selection3 = new Selection("3/1", "lost", "1/4");
        $betType = new PatentBetType();
        $calculator = new Calculator(0.50, false, [ $selection, $selection2, $selection3 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(3.50, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-3.50, $result['profit']);
    }

    public function testBetTypePatentWithVoidSelection()
    {
        $selection = new Selection("5/2", "void", "1/4");
        $selection2 = new Selection("6/4", "won", "1/4");
        $selection3 = new Selection("3/1", "won", "1/4");
        $betType = new PatentBetType();
        $calculator = new Calculator(0.50, false, [ $selection, $selection2, $selection3 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(3.50, $result['outlay']);
        $this->assertSame(17.00, $result['returns']);
        $this->assertSame(13.50, $result['profit']);
    }
}
