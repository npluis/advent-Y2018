<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 11-12-18
 * Time: 7:20
 */

namespace Advent\Y2018\Day;

use Advent\Y2018\Helper\PowerGrid;

class Day11 extends AbstractDayProblem
{
    public function solve(array $input)
    {

        /**
         * -2  -4   4   4   4
         * -4   4   4   4  -5
         * 4   3   3   4  -4
         * 1   1   2   4  -3
         * -1   0   2  -5  -2
         */


        $grid = new PowerGrid(9221);
        $grid->setSquare(3);


        $answer = $grid->createGrid(0, 300, 0, 300);
        return implode(',',$answer[1]);


    }

    public function solve2(array $input)
    {
        $max = PHP_INT_MIN;
        for ($x = 0; $x < 100; $x++) {
            $grid = new PowerGrid($input[0]);
            $grid->setSquare($x);
            $answer = $grid->createGrid(0, 300, 0, 300);
            if ($answer[0] > $max) {
                $max = $answer[0];
            } else {
                return implode(',', $answer[1]).','.$x;
            }

          //  echo "Grid: $x\t$answer[0]\t".implode(',', $answer[1])."\n";
        }
    }

    public function parseInput(array $input)
    {
        // TODO: Implement parseInput() method.
    }
}