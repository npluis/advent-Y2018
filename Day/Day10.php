<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 10-12-18
 * Time: 6:24
 */

namespace Advent\Y2018\Day;

use Advent\Y2018\Helper\NavPoint;

class Day10 extends AbstractDayProblem
{

    /**
     * @var NavPoint[]
     */
    private $grid = [];

    private $maxX = 0;
    private $maxY = 0;

    public function solve2(array $input)
    {
        $this->solve($input);
    }

    public function solve(array $input)
    {

        $this->parseInput($input);

        $min = PHP_INT_MAX;
        $max = PHP_INT_MIN;
        foreach ($this->grid as $navPoint) {
            $range = $navPoint->willBeVisible();
            $min = min($min, $range[1]);
            $max = max($max, $range[0]);
        }

        $closest = PHP_INT_MAX;
        $second = PHP_INT_MAX;
        for ($i = $max; $i <= $min; $i++) {
            $grid = $this->gridAtSecond($i);
            $closeness = $this->closeness($grid);
            if ($closest > $closeness) {
                $closest = $closeness;
                $second = $i;
            }
        }


        $this->printGrid($second);
        echo "\n\n\n";
    }

    public function parseInput(array $input)
    {


        foreach ($input as $line) {
            preg_match_all("/([\-]*\d+)/", $line, $matches);
            $navPoint = new NavPoint($matches[1][0], $matches[1][1], $matches[1][2], $matches[1][3]);
            $this->grid[] = $navPoint;


        }
    }

    private function gridAtSecond(int $second): array
    {
        $tempGrid = [];
        foreach ($this->grid as $navPoint) {
            $newPos = $navPoint->calcPosition($second);
            $tempGrid[$newPos[1]][$newPos[0]] = "#";
        }

        return $tempGrid;
    }

    private function closeness(array $grid)
    {
        $lines = [];
        foreach ($grid as $line) {
            $lines += $line;
        }

        return count($grid);
    }

    public function printGrid($second)
    {
        $minX = 0;
        $maxX = 0;
        $tempGrid = $this->gridAtSecond($second);

        foreach ($tempGrid as $line) {
            $coord = array_keys($line);
            $coord[] = $minX;
            $coord[] = $maxX;
            $minX = min($coord);
            $maxX = max($coord);

        }
        $maxY = max(array_keys($tempGrid));

        $lineLength = $maxX - $minX;
        $baseLine = str_repeat(' ', $lineLength);
        echo "*****$second****\n";
        for ($y = min(array_keys($tempGrid)); $y <= $maxY; $y++) {
            $line = $baseLine;
            if (isset($tempGrid[$y])) {
                foreach (array_keys($tempGrid[$y]) as $x) {
                    $line[$x] = '#';
                }
            }
            echo "\t".trim($line)."\n";
        }
    }
}