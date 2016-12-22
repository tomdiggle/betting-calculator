<?php

namespace BettingCalculator;

class Selection
{
    /**
     * 
     *
     * @var string
     **/
    public $odds;

    /**
     * 
     *
     * @var BetStatus
     **/
    public $status;

    /**
     * 
     *
     * @var EachWayOdds
     **/
    public $eachWayOdds;

    /**
     * 
     *
     * @var    string   $odds
     * @var    string   $status
     * @var    string   $eachWayOdds
     * @return void
     **/
    public function __construct(string $odds, string $status, string $eachWayOdds)
    {
        $this->odds = $odds;
        $this->status = $status;
        $this->eachWayOdds = $eachWayOdds;
    }
}
