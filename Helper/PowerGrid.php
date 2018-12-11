<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 11-12-18
 * Time: 7:22
 */

namespace Advent\Y2018\Helper;

class PowerGrid
{
    /**
     * @var int
     */
    private $serial;
    /**
     * @var array
     */
    private $rollingX;
    /**
     * @var \SplStack
     */
    private $rollingY;
    private $sizeX = 37;
    private $sizeY = 49;

    private $sums = [];

    private $grid = [];

    private $square = 0;

    /**
     * PowerGrid constructor.
     *
     * @param int $serial
     */
    public function __construct(int $serial)
    {
        $this->serial = $serial;
    }

    /**
     * @param int $square
     */
    public function setSquare(int $square): void
    {
        $this->square = $square;
    }


    public function cacheGrid($minX, $width, $minY, $height)
    {
        $maxY = $minY + $height;
        $maxX = $minX + $width;

        for ($y = $minY; $y <= $maxY; $y++) {
            $newValue = $this->getValueAtCoord(0, $y);
            $this->grid[0][$y] = $newValue;
            for ($x = $minX; $x <= $maxX; $x++) {
                $newValue = $this->getValueAtCoord($x + 1, $y);
                $this->grid[$x + 1][$y] = $newValue;
            }
        }
    }

    public function getValueAtCoord($x, $y)
    {
        $rackId = $x + 10;
        $begin = (($rackId * $y) + $this->serial) * $rackId;
        $hundreths = strlen($begin) < 3 ? 0 : (int)substr($begin, -3, 1);

        return $hundreths - 5;
    }

    public function createGrid($minX, $width, $minY, $height)
    {

        $square = $this->square;
        $maxY = $minY + $height;
        $maxX = $minX + $width;


        for ($y = $minY; $y <= $maxY; $y++) {
            $rollingX = new \SplDoublyLinkedList();

            for ($x = $minX; $x <= $maxX; $x++) {
                $newValue = $this->grid[$x + 1][$y];
                $rollingX->push($newValue);
                if (($x) - $minX >= ($square - 1)) {
                    // print_r($rollingX);
                    $prevValue = $rollingX->shift();
                    $sum = $prevValue;
                    $rollingX->rewind();
                    while ($rollingX->valid()) {
                        $sum += $rollingX->current();
                        $rollingX->next();
                    }
                    $sumX = $sum;
                    $this->rollingX[$x][$y] = $sumX;
                }
            }


            //  echo "\n";
        }

        //calc rolling value for Y and check max
        $max = PHP_INT_MIN;
        $coord = [];
        for ($y = $minY + 1; $y < $maxY - 1; $y++) {
            for ($x = $minX; $x <= $maxX; $x++) {
                $current = 0;
                for ($i = 0; $i < $square; $i++) {
                    $current += $this->rollingX[$x][$y + $i - 1] ?? PHP_INT_MIN;
                }

                $this->sums[$x.','.$y] = $current;

                if ($current > $max) {
                    $max = $current;
                    $coord = [$x - $square + 3, $y];
                }

            }
        }

        arsort($this->sums);
        //   print_r($this->sums);
        $topLeft = [$coord[0] - 1, $coord[1] - 1];

        return [$max, $topLeft, $coord];
    }
}
