<?php

use BettingCalculator\Selection;

class SelectionClassTest extends PHPUnit_Framework_TestCase
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
    
    public function testSelectionCanInitialise()
    {
        $selection = new Selection("1/2", "won", "1/4");

        $this->assertSame("1/2", $selection->odds);
        $this->assertSame("won", $selection->status);
        $this->assertSame("1/4", $selection->eachWayOdds);
    }    
}
