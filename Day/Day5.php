<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5-12-18
 * Time: 5:55
 */

namespace Advent\Y2018\Day;

class Day5 extends AbstractDayProblem
{

    protected $day = 5;

    private $pairs = [];




    public function solve(array $input)
    {
        $string = $input[0];

        return $this->reactLength($string);
    }

    private function reactLength($string)
    {
        return strlen($this->react($string));
    }

    private function react($string)
    {
        $pairs = $this->getPairs();
        do {
            $orgLength = strlen($string);
            $string = str_replace($pairs, '', $string);
        } while ($orgLength > strlen($string));

        return $string;
    }

    private function getPairs()
    {
        if (count($this->pairs) > 0) {
            return $this->pairs;
        }
        $lower = range('a', 'z');
        $upper = range('A', 'Z');
        $pairs = [];
        foreach ($lower as $charKey => $low) {
            $pairs[] = $low.$upper[$charKey];
            $pairs[] = $upper[$charKey].$low;
        }
        $this->pairs = $pairs;

        return $pairs;
    }

    public function solve2(array $input)
    {
        $string = $input[0];

        $stats = array_fill_keys(range('a', 'z'), 0);
        $string = $this->react($string);
        $min=PHP_INT_MAX;
        foreach (array_keys($stats) as $char) {
            $remainingString = str_replace([$char, strtoupper($char)], '', $string);
            $length = $this->reactLength($remainingString);
            if ($length<$min) {
                $min = $length;
            }
        }
        return $min;
    }

    public function parseInput(array $input)
    {
        //
    }
}
