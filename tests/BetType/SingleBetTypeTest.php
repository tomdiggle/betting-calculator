<?php

use BettingCalculator\Calculator;
use BettingCalculator\Selection;
use BettingCalculator\BetType\SingleBetType;

class SingleBetTypeTest extends PHPUnit_Framework_TestCase
{
    private $selection1;

    /**
     * PHPUnit setup routines
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->selection1 = new Selection("20/1", "won", "1/4");
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
    
    public function testBetTypeSingle()
    {
        $betType = new SingleBetType();
        $this->assertSame("Single", $betType->name());
        $this->assertSame(1, $betType->totalSelections());
        $this->assertSame(1, $betType->totalBets());
        $this->assertTrue($betType->withSingles());
        $this->assertFalse($betType->isAccumulated());
    }

    public function testBetTypeSingleWithWonSelection()
    {
        $betType = new SingleBetType();
        $calculator = new Calculator(20.00, false, [ $this->selection1 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(20.00, $result['outlay']);
        $this->assertSame(420.00, $result['returns']);
        $this->assertSame(400.00, $result['profit']);
    }

    public function testBetTypeSingleWithPlacedSelection()
    {
        $this->selection1->status = "placed";
        $betType = new SingleBetType();
        $calculator = new Calculator(20.00, false, [ $this->selection1 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(20.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-20.00, $result['profit']);
    }

    public function testBetTypeSingleWithLostSelection()
    {
        $this->selection1->status = "lost";
        $betType = new SingleBetType();
        $calculator = new Calculator(20.00, false, [ $this->selection1 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(20.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-20.00, $result['profit']);
    }

    public function testBetTypeSingleWithVoidSelection()
    {
        $this->selection1->status = "void";
        $betType = new SingleBetType();
        $calculator = new Calculator(20.00, false, [ $this->selection1 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(20.00, $result['outlay']);
        $this->assertSame(20.00, $result['returns']);
        $this->assertEmpty($result['profit']);
    }

    // Each Way

    public function testBetTypeSingleEachWayWithWonSelection()
    {
        $betType = new SingleBetType();
        $calculator = new Calculator(10.00, true, [ $this->selection1 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(20.00, $result['outlay']);
        $this->assertSame(270.00, $result['returns']);
        $this->assertSame(250.00, $result['profit']);
    }

    public function testBetTypeSingleEachWayWithPlacedSelection()
    {
        $this->selection1->status = "placed";
        $betType = new SingleBetType();
        $calculator = new Calculator(10.00, true, [ $this->selection1 ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(20.00, $result['outlay']);
        $this->assertSame(60.00, $result['returns']);
        $this->assertSame(40.00, $result['profit']);
    }

}
