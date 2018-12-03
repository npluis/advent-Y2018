<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 3-12-18
 * Time: 7:57
 */

namespace Advent\Y2018\Day;

use Advent\Y2018\Helper\Claim;

class Day3 extends AbstractDayProblem
{

    protected $day = 3;

    private $grid = [];

    /**
     * @var Claim[]
     */
    private $claims = [];

    public function solve(array $input)
    {
        $this->parseInput($input);

        $filtered = array_filter(
            $this->grid,
            function ($coord) {
                return count($coord) > 1;
            }
        );

        return count($filtered);
    }

    public function parseInput(array $input)
    {
        foreach ($input as $claimString) {
            if (strlen(trim($claimString)) === 0) {
                continue;
            }
            $claim = new Claim($claimString);
            $this->addClaimToGrid($claim);
        }
    }

    private function addClaimToGrid(Claim $claim)
    {
        $this->claims[$claim->getId()] = $claim;

        foreach ($claim->getFootprint() as $coord) {
            if (!isset($this->grid[$coord])) {
                $this->grid[$coord][$claim->getId()] = $claim;
            } else {
                //another claim here
                //    echo "colliding ".$claim->getId()."\n";
                $claim->setCollide(true);

                foreach ($this->grid[$coord] as $otherClaim) {
                    $otherClaim->setCollide(true);
                    //         echo "colliding ".$otherClaim->getId()."\n";
                }
                $this->grid[$coord][$claim->getId()] = $claim;
            }
        }
    }

    public function solve2(array $input)
    {

        if (count($this->grid) === 0) {
            $this->parseInput($input);
        }
        $possible = [];
        foreach ($this->claims as $claim) {
            if ($claim->getCollide() !== true) {
                $possible[] = $claim;
            }
        }
        if (count($possible) !== 1) {
            print_r($possible);
            throw new \Exception("more than one possible?");
        }

        return $possible[0]->getId();
    }
}
