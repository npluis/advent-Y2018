<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 1-12-18
 * Time: 14:19
 */

namespace Advent\Y2018\Day;

class Day1 extends AbstractDayProblem
{

    protected $day = 1;

    public function solve(array $input)
    {
        return array_sum($input);
    }

    public function solve2(array $input)
    {
        $result = 0;
        $freqs[$result] = 0;
        while (true) {
            foreach ($input as $num) {
                $result += $num;
                if (isset($freqs[$result])) {
                    //found twice
                    return $result;
                }
                $freqs[$result] = 1;
            }
        }
    }
}
