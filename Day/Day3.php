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
        $num = 0;

        print_r($this->grid);die();
        foreach ($this->grid as $col=>$row) {
            foreach ($row as $cell) {
                print_r($col);
                print_r($row);
                print_r($cell);die();
                if (count($cell) > 1) {
                    $num++;
                }
            }
        }

        return $num;
    }

    public function parseInput(array $input)
    {
        $maxX=0;$maxY=0;
        foreach ($input as $claimString) {
            $claim = new Claim($claimString);
            $this->addClaimToGrid($claim);
            $maxX = max($maxX, $claim->getX());
            $maxY = max($maxY, $claim->getY());


        }
    }

    private function addClaimToGrid(Claim $claim)
    {

        $this->grid = array_merge_recursive($this->grid, $claim->getnewFootPrint());
        $claimId = $claim->getId();
        $this->claims[$claimId] = $claim;


        $collides=[];

        foreach ($claim->getFootprint() as $coord) {
            if (isset($this->grid[$coord])) {
                $collides+=$this->grid[$coord];
            }
            $this->grid[$coord][$claimId] = $claim;
        }

        if ($collides) {
            foreach (array_keys($collides) as $claimId) {
                $this->claims[$claimId]->setCollide(true);
                $claim->setCollide(true);
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
       //     print_r($possible);
       //     throw new \Exception("more than one possible?");
        }

        return $possible[0]->getId();
    }
}
