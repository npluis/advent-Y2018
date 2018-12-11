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

    /**
     * PowerGrid constructor.
     *
     * @param int $serial
     */
    public function __construct(int $serial)
    {
        $this->serial = $serial;

    }

    public function checkMaxSquare($minX, $maxX, $minY, $maxY)
    {
        $totalSum = 0;

        for ($x = $minX; $x <= $maxX; $x++) {
            $totalSum += array_sum(array_slice($this->grid[$x], $minY, ($maxY - $minY)));
        }
        echo "SUM $totalSum\n";
    }

    public function createGrid($minX, $width, $minY, $height)
    {

        $maxY = $minY + $height;
        $maxX = $minX + $width;

        for ($y = $minY; $y <= $maxY; $y++) {
            $prevValue = 0;
            $current = 0;
            $newValue = $this->getValueAtCoord(0, $y);
            $this->grid[0][$y] = $newValue;
            $rollingX = new \SplDoublyLinkedList();

            for ($x = $minX; $x <= $maxX; $x++) {
                $newValue = $this->getValueAtCoord($x + 1, $y);
                $this->grid[$x + 1][$y] = $newValue;
                $rollingX->push($newValue);
                if (($x) - $minX >= 2) {
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
                //    echo $current."[$newValue $prevValue $sumX]   \t";
                $current = $newValue;
                // print_r($rollingX);
            }


            //  echo "\n";
        }

        //calc rolling value for Y and check max
        $max = PHP_INT_MIN;
        $coord = [];
        for ($y = $minY + 1; $y < $maxY - 1; $y++) {
            for ($x = $minX; $x <= $maxX; $x++) {
                $current = $this->rollingX[$x][$y - 1] + $this->rollingX[$x][$y] + $this->rollingX[$x][$y + 1];
                $this->sums[$x.','.$y] = $current;

                if ($current > $max) {
                    $max = $current;
                    $coord = [$x, $y];
                }
            }
        }

        arsort($this->sums);
        //   print_r($this->sums);
        $topLeft = [$coord[0] - 1, $coord[1] - 1];

        return [$max, $topLeft, $coord];
    }

    public function getValueAtCoord($x, $y)
    {
        $rackId = $x + 10;
        $begin = (($rackId * $y) + $this->serial) * $rackId;
        $hundreths = strlen($begin) < 3 ? 0 : (int)substr($begin, -3, 1);

        return $hundreths - 5;
    }

    public function rollingSum()
    {
        $sumX = 0;
        $sumY = 0;
        $max = 0;
        $rollingX = new \SplDoublyLinkedList();
        $rollingY = new \SplDoublyLinkedList();

        $rollingGridX = [];
        $rollingGridY = [];

        for ($x = 0; $x < 3; $x++) {
            $value = $this->getValueAtCoord($x, 0);
            $rollingX->push($value);
            $sumX += $value;
            $rollingGridX[$x] = $sumX;
        }

        for ($y = 0; $y < 3; $y++) {
            $value = $this->getValueAtCoord(0, $y);
            $rollingY->push($value);
            $sumY += $value;
            $rollingGridY[$y] = $sumY;
        }

        print_r($rollingGridX);
        print_r($rollingGridY);
        for ($x = 3; $x < $this->sizeX; $x++) {

            for ($y = 0; $y < $this->sizeY; $y++) {

                $sumX = 0;
                for ($i = 0; $i < 3; $i++) {
                    $value = $this->getValueAtCoord($i, 0);
                    $rollingX->push($value);
                    $sumX += $value;
                }

                $newValue = $this->getValueAtCoord($x + 1, $y);
                $rollingX->push($newValue);
                $prevSumX = $sumX;
                $sumX += $newValue;
                $sumX -= $rollingX->shift();
                echo "\nnext x value @ $x,$y: ".$newValue."\t sum: $prevSumX => $sumX\n";
                /*

                                $newValue = $this->getValueAtCoord($x, $y+1);
                                $rollingY->push($newValue);
                                $sumY += ($newValue - $rollingY->shift());
                                echo "\nnext y value @ $x,$y: ".$newValue ."\t sum: (X) $sumX + (Y) $sumY\n";
                                echo "\n\tA $sumX => $sumY\t " . ($sumX+$sumY);
                                if (($sumY + $sumX) > $max) {
                                    $max = $sumX + $sumY;
                                    echo "\n\nnew high $max @ $x,$y";
                                }

                                if ($x===33 && $y===45) {
                                    echo "DEBUG\n";
                                    print_r($rollingX);
                                    print_r($rollingY);
                                }
                                */
            }


        }


    }

}
