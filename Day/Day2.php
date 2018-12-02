<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 1-12-18
 * Time: 14:19
 */

namespace Advent\Y2018\Day;

class Day2 extends AbstractDayProblem
{

    protected $day = 2;

    public function solve(array $input)
    {
        $all = [0, 0];
        foreach ($input as $box) {
            $checksum = $this->checksumBox($box);

            $all[0] += $checksum[0];
            $all[1] += $checksum[1];
        }

        return $all[0] * $all[1];
    }

    private function checksumBox(string $input)
    {
        $chars = count_chars(trim($input));

        return [in_array(2, $chars) ? 1 : 0, in_array(3, $chars) ? 1 : 0];
    }

    public function solve2(array $input)
    {
        //add dummy letter
        array_walk(
            $input,
            function (&$value) {
                $value= 'A'.$value;
            }
        );

        //sort
        sort($input, SORT_STRING);
        $boxId = array_shift($input);
        $length = strlen($boxId) - 1;
        $string = '';
        do {
            $prevBoxId = $boxId;
            $boxId = array_shift($input);
            $same = similar_text($boxId, $prevBoxId);
            if ($same === $length) {
                //ignore first dummy char
                for ($char = 1; $char <= $length; $char++) {
                    if ($boxId[$char] === $prevBoxId[$char]) {
                        $string .= $boxId[$char];
                    }
                }
                return $string;
            }
        } while (count($input) > 0);
        throw new \Exception('Cant find similar');
    }
}
