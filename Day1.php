<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 1-12-18
 * Time: 14:19
 */

namespace Advent\Y2018;

class Day1 extends AbstractDayProblem
{

    protected $day = 1;

    public function solve(string $input)
    {
        $sepChar = strpos($input, ",") !== false ? "," : "\n";

        return array_sum(explode($sepChar, $input));
    }

    public function solve2(string $input)
    {
        $sepChar = strpos($input, ",") !== false ? "," : "\n";
        $array = explode($sepChar, $input);
        $result = 0;
        $freqs[$result] = 0;
        while (true) {
            foreach ($array as $num) {
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
