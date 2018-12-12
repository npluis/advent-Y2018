<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 12-12-18
 * Time: 6:27
 */

namespace Advent\Y2018\Day;

use Advent\Y2018\Helper\PotRule;

class Day12 extends AbstractDayProblem
{
    private $start = '';
    private $rules = [];


    private $minPot=0;

    private function addPots($state) {
   //     echo $state.PHP_EOL;
        $org = strlen($state);
        $state = '...'.ltrim($state, '.');
        $this->minPot -= (strlen($state) - $org);

    //    echo $state."[$org] ".strlen($state)." $this->minPot\n";

        $state = rtrim($state, '.').'...';
        return $state;

    }


    public function solve(array $input)
    {
        if (!$this->rules) {
            $this->parseInput($input);
        }
        $state = $this->start;
        $state= $this->addPots($state);
        $minPot = 0;
        for ($generation = 1; $generation <= 20; $generation++) {
            $nextState = '..';
            //add empty pots in front
            for ($x = $minPot; $x < strlen($state) - 2; $x++) {
                $situation = substr($state, $x, 5);
                $result = $this->rules[$situation] ?? '.';

                $nextState .= $result;
            }
            //echo ($generation - 1)."\t".$state."\n";
           // $nextState = str_repeat('.', abs($minPot)).$state;
            $nextState=$this->addPots($nextState);
            $state = $nextState;

           // echo "\t".$nextState." [$this->minPot]\n\n\n";
        }


    ///    echo $state.PHP_EOL;
        $org = strlen($state);
        $state = '...'.ltrim($state, '.');
        $minPot -= (strlen($state) - $org);

    //    echo $state."[$org] ".strlen($state)." $minPot\n";

        $pot = $minPot;
        $total = 0;
        foreach (str_split($state) as $num => $char) {
            if ($char === '#') {
             //   echo ($num + $this->minPot)."\n";
                $total += $num + $this->minPot;
                $pot++;
            }
        }

        return $total;
        echo $state."\n";
        echo $minPot."\n";
    }

    public function parseInput(array $input)
    {
        print_r($input);
        $start = array_shift($input);
        $this->start = trim(substr($start, strpos($start, ':') + 1));
        foreach ($input as $line) {
            $line = trim($line);
            if (strlen($line) === 0) {
                continue;
            }
            $this->rules [substr($line, 0, 5)] = substr($line, -1);
        }

    }

    public function solve2(array $input)
    {
        // TODO: Implement solve2() method.
    }
}