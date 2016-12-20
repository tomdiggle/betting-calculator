<?php

class SingleBetTypeTest extends PHPUnit_Framework_TestCase
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
    
    public function testBetTypeSingle()
    {
        $betType = new SingleBetType();
        $this->assertSame("Single", $betType->name());
        $this->assertSame(1, $betType->totalSelections());
        $this->assertSame(1, $betType->totalBets());
        $this->assertTrue($betType->withSingles());
        $this->assertFalse($betType->isAccumulator());
    }

    public function testBetTypeSingleWithWonSelection()
    {
        $selection = new Selection("20/1", "won", "1/4");
        $betType = new SingleBetType();
        $calculator = new BetCalculator(20.00, false, [ $selection ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(20.00, $result['outlay']);
        $this->assertSame(420.00, $result['returns']);
        $this->assertSame(400.00, $result['profit']);
    }

    public function testBetTypeSingleWithPlacedSelection()
    {
        $selection = new Selection("20/1", "placed", "1/4");
        $betType = new SingleBetType();
        $calculator = new BetCalculator(20.00, false, [ $selection ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(20.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-20.00, $result['profit']);
    }

    public function testBetTypeSingleWithLostSelection()
    {
        $selection = new Selection("20/1", "lost", "1/4");
        $betType = new SingleBetType();
        $calculator = new BetCalculator(20.00, false, [ $selection ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(20.00, $result['outlay']);
        $this->assertEmpty($result['returns']);
        $this->assertSame(-20.00, $result['profit']);
    }

    public function testBetTypeSingleWithVoidSelection()
    {
        $selection = new Selection("20/1", "void", "1/4");
        $betType = new SingleBetType();
        $calculator = new BetCalculator(20.00, false, [ $selection ], $betType);
        $result = $calculator->calculate();

        $this->assertSame(20.00, $result['outlay']);
        $this->assertSame(20.00, $result['returns']);
        $this->assertEmpty($result['profit']);
    }
}
