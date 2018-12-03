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
        $chars = count_chars(trim($input), 1);

        return [in_array(2, $chars) ? 1 : 0, in_array(3, $chars) ? 1 : 0];
    }

    public function solve2(array $input)
    {

        $answer = $this->checkArray($input);
        if (!$answer) {
            $answer = $this->checkArray($input, 'REV');
        }
        if (!$answer) {
            throw new \Exception('Cant find similar');
        }

        return $answer;
    }

    private function checkArray(array $input, $sort = 'NORMAL')
    {
        //sort reversed array, so we can also find edge case
        if ($sort !== 'NORMAL') {
            array_walk(
                $input,
                function (&$value) {
                    $value = strrev($value);
                }
            );
        }
        //add dummy letter
        array_walk(
            $input,
            function (&$value) {
                $value = 'A'.$value;
            }
        );

        //sort
        sort($input, SORT_STRING);

        $boxId = array_shift($input);
        $length = strlen($boxId) - 1;
        do {
            $prevBoxId = $boxId;
            $boxId = array_shift($input);
            $same = similar_text($boxId, $prevBoxId);
            if ($same === $length) {
                if ($sort !== 'NORMAL') {
                    $boxId = substr($boxId, 1, 1).strrev(substr($boxId, 1));
                    $prevBoxId = substr($prevBoxId, 1, 1).strrev(substr($prevBoxId, 1));
                }
                $string = $this->extractSame($boxId, $prevBoxId);
                return $string;
            }
        } while (count($input) > 0);
        return false;
    }

    /**
     * @param        $boxId
     * @param        $prevBoxId
     *
     * @return string
     */
    public function extractSame($boxId, $prevBoxId): string
    {
        $length = strlen($boxId) - 1;
        $string = '';
        //ignore first dummy char
        for ($char = 1; $char <= $length; $char++) {
            if ($boxId[$char] === $prevBoxId[$char]) {
                $string .= $boxId[$char];
            }
        }

        return $string;
    }
}
