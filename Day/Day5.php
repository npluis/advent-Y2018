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

    private $reacted;

    public function solve(array $input)
    {
        $string = $input[0];


        return strlen($this->react_str_replace($string));
        return strlen($this->react($string));
    }



    private function react($string) : string
    {



        $pairs = $this->getPairs();
        $count=0;
        do {
            //$orgLength = strlen($string);
            $string = str_replace($pairs, '', $string, $count);
        } while ($count>0);
        $this->reacted = $string;

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
        if ($this->reacted) {
            $string = $this->reacted;
        } else {
            $string = $input[0];
            $string = $this->react($string);
        }
        $stats = array_fill_keys(range('a', 'z'), 0);

        $min = PHP_INT_MAX;
        foreach (array_keys($stats) as $char) {
            $remainingString = str_replace([$char, strtoupper($char)], '', $string);
            $length = strlen($this->react($remainingString));
            if ($length < $min) {
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
