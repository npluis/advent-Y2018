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
        -2  -4   4   4   4
        -4   4   4   4  -5
        4   3   3   4  -4
        1   1   2   4  -3
        -1   0   2  -5  -2
         */


        $grid = new PowerGrid(42);

        $answer = $grid->createGrid(0,300,0,300);
        print_r($answer);

     //   echo $grid->checkMaxSquare(0,300,0,300);
        return;
        $grid->rollingSum();
    }

    public function solve2(array $input)
    {
        // TODO: Implement solve2() method.
    }

    public function parseInput(array $input)
    {
        // TODO: Implement parseInput() method.
    }

}