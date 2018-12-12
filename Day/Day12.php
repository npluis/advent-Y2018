<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 12-12-18
 * Time: 6:27
 */

namespace Advent\Y2018\Day;

class Day12 extends AbstractDayProblem
{
    private $start = '';
    private $rules = [];


    private $minPot = 0;

    public function solve(array $input)
    {
        if (!$this->rules) {
            $this->parseInput($input);
        }

        return $this->generate(20);
    }

    public function parseInput(array $input)
    {
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

    private function generate(int $generations)
    {

        $this->minPot = 0;
        $state = $this->start;
        $state = $this->addPots($state);
        $prevCount = $this->calcTotal($state);
        for ($generation = 1; $generation <= $generations; $generation++) {
            $nextState = '';
            //add empty pots in front
            for ($x = 0; $x < strlen($state); $x++) {
                $situation = substr($state, $x, 5);
                $result = $this->rules[$situation] ?? '.';

                $nextState .= $result;
            }
            $nextState = $this->addPots('..'.$nextState);
            $newCount = $this->calcTotal($nextState);
            if ($state === $nextState) {
                //state is the same, so it hasn't changed and won't change the next generations.
                //they will only move in the pots, so calc diff for this round and multiply by next rounds
                $diff = $newCount - $prevCount;

                return ($diff * ($generations - $generation)) + $newCount;
            }
            $prevCount = $newCount;
            $state = $nextState;
        }

        return $prevCount;
    }

    private function addPots($state)
    {
        //     echo $state.PHP_EOL;
        $org = strlen($state);
        $state = '...'.ltrim($state, '.');
        $this->minPot -= (strlen($state) - $org);

        //    echo $state."[$org] ".strlen($state)." $this->minPot\n";

        $state = rtrim($state, '.').'...';

        return $state;
    }

    private function calcTotal($state)
    {
        $total = 0;
        foreach (str_split($state) as $num => $char) {
            if ($char === '#') {
                $total += $num + $this->minPot;
            }
        }

        return $total;
    }

    public function solve2(array $input)
    {
        return $this->generate(50000000000);
    }
}
