<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 10-12-18
 * Time: 6:24
 */

namespace Advent\Y2018\Day;

use Advent\Y2018\Helper\Letter;
use Advent\Y2018\Helper\NavPoint;
use Advent\Y2018\Helper\OCR;

class Day10 extends AbstractDayProblem
{

    /**
     * @var NavPoint[]
     */
    private $grid = [];

    private $solution = '';

    public function solve2(array $input)
    {
        //  $this->solve($input);
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


        $gridLines = $this->createGrid($second);
        //see if we can find the letter width
        $letterWidth = 0;
        foreach ($gridLines as $line) {
            //see if we can find a full line;
            if (preg_match('/(#+)/', $line, $match)) {
                $letterWidth = max($letterWidth, strlen($match[1]));
            };
        }
        $letters=[];
        $letterWidth += 2;//space between letters
        foreach ($gridLines as $line) {
            foreach (str_split(($line), $letterWidth) as $k => $letterLine) {
                $letters[$k][] = str_pad(rtrim($letterLine), $letterWidth - 2, ' ');
            }
        }

        foreach ($letters as $letter) {
            $ocr = new OCR($letter);
            $ocrResult = $ocr->recognise();
            if (count($ocrResult) === 1) {
                $this->solution .= $ocrResult[0];
            } elseif (count($ocrResult) === 0) {
                $this->solution .= '?';
            } else {
                $this->solution .= '['.implode('', $ocrResult).']';
            }


        }

        $this->printGrid($second);
        //   echo PHP_EOL.PHP_EOL.PHP_EOL;
        echo PHP_EOL.PHP_EOL;
        echo $this->solution;
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

    private function createGrid($second)
    {
        $tempGrid = $this->gridAtSecond($second);

        list($minX, $minY, $maxX, $maxY) = $this->gridSize($tempGrid);
        $lineLength = $maxX - $minX;
        $baseLine = str_repeat(' ', $lineLength);
        $lines = [];

        for ($y = $minY; $y <= $maxY; $y++) {
            $line = $baseLine;
            if (isset($tempGrid[$y])) {
                foreach (array_keys($tempGrid[$y]) as $x) {
                    $line[$x - $minX] = '#';
                }
            }

            $lines[] = ($line);
        }

        return $lines;
    }

    private function gridSize(array $tempGrid)
    {
        $minX = PHP_INT_MAX;
        $maxX = 0;


        foreach ($tempGrid as $line) {
            $coord = array_keys($line);
            $coord[] = $minX;
            $minX = min($coord);
            array_pop($coord);
            $coord[] = $maxX;
            $maxX = max($coord);

        }
        $maxY = max(array_keys($tempGrid));
        $minY = min(array_keys($tempGrid));

        return [$minX, $minY, $maxX, $maxY];
    }

    private function printGrid(int $second)
    {
        $grid = $this->createGrid($second);
        foreach ($grid as $line) {
            echo "\t".rtrim($line).PHP_EOL;
        }
    }
}
