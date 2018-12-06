<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 6-12-18
 * Time: 5:48
 */

namespace Advent\Y2018\Day;

use Advent\Y2018\Helper\Coordinate;

class Day6 extends AbstractDayProblem
{

    protected $day=6;
    private $grid;

    /**
     * @var Coordinate[]
     */
    private $coords = [];

    private $safe=0;

    private $safeLimit=10000;

    /**
     * @param int $safeLimit
     */
    public function setSafeLimit(int $safeLimit): void
    {
        $this->safeLimit = $safeLimit;
    }



    public function solve(array $input)
    {


        if (!$this->coords) {
            $this->parseInput($input);
        }

        $max=0;

        foreach ($this->coords as $coordinate) {
            if ($coordinate->getNumClose() > $max) {
                if ($coordinate->isFinitive()) {
                    continue;
                }
                $max = $coordinate->getNumClose();
            }
        }
        return $max;
    }

    public function solve2(array $input)
    {
        if (!$this->coords) {
            $this->parseInput($input);
        }
        return $this->safe;
    }

    public function parseInput(array $input)
    {
        $minHeight = PHP_INT_MAX;
        $maxHeight = 0;
        $minWidth = PHP_INT_MAX;
        $maxWidth = 0;

        $baseDistances=[];

        foreach ($input as $num => $coord) {
            $coords = explode(",", $coord);
            $coordinate = new Coordinate($coords[0], $coords[1]);
            $this->coords[$coordinate->getCoord()] = $coordinate;
            $coordinate->setName(chr($num + 65));

            $minHeight = ($minHeight < $coords[1]) ? $minHeight : $coords[1];
            $maxHeight = ($maxHeight > $coords[1]) ? $maxHeight : $coords[1];
            $minWidth = ($minWidth < $coords[1]) ? $minWidth : $coords[0];
            $maxWidth = ($maxWidth > $coords[1]) ? $maxWidth : $coords[0];

            $closestCoords[$coordinate->getCoord()] = 0;
        }


        for ($x = 0; $x <= $maxWidth; $x++) {
            for ($y = 0; $y <= $maxHeight; $y++) {
                $this->grid[$x.','.$y] = 0;
                $distances = [];
                $safe = 0;
                foreach ($this->coords as $coord => $coordinate) {
                    $distance = $coordinate->calcDistance($x, $y);
                    $distances[$distance][] = $coordinate;
                    $safe += $distance;
                }
                if ($safe < $this->safeLimit) {
                    $this->safe++;
                }
                ksort($distances);
                /**
                 * @var Coordinate[] $shortest
                 */

                $shortest = reset($distances);
                if (!$shortest) {
                    continue;
                }
                $this->grid[$x.','.$y] += key($distances);
                if (count($shortest) > 1) {
                    //shared close of no distance
                } else {
                    if ($x <= $minWidth || $x >= $maxWidth || $y <= $minHeight || $y >= $maxHeight) {
                        $shortest[0]->setFinitive(true);
                        //      echo $shortest[0]->getName() . " finitive\n";
                    } else {
                        $shortest[0]->addClosest();
                        $closestCoords[$shortest[0]->getCoord()] = $shortest[0];
                    }
                }
            }
        }
    }
}
