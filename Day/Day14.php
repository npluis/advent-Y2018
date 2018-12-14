<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 14-12-18
 * Time: 6:05
 */

namespace Advent\Y2018\Day;

use Advent\Y2018\Helper\Elf;

class Day14 extends AbstractDayProblem
{

    /**
     * @var Elf
     */
    private $elf1;

    /**
     * @var Elf
     */
    private $elf2;

    /**
     * @var array
     */
    private $recipes;
    private $find = [];
    private $found = 0;

    public function solve(array $input)
    {

        $max = (int)$input[0];
        $this->prepare();
        $this->makeRecipesMax($max);

        $result = '';
        for ($i = $max; $i < $max + 10; $i++) {
            $result .= $this->recipes[$i];
        }

        return $result;
    }

    private function prepare()
    {
        $this->recipes = [];
        $this->elf1 = new Elf(3, 0);
        $this->elf2 = new Elf(7, 1);

        $this->recipes[] = 3;
        $this->recipes[] = 7;
        $this->newRecipe();
    }

    private function newRecipe($return = false)
    {
        $newRecipe = $this->elf1->getCurrentRecipe() + $this->elf2->getCurrentRecipe();
        if ($newRecipe >= 10) {
            foreach (str_split($newRecipe) as $char) {
                $this->recipes[] = $char;
            }
        } else {
            $this->recipes[] = $newRecipe;
        }
        if ($return) {
            return str_split($newRecipe);
        }
    }

    private function makeRecipesMax($max)
    {
        $max += 10;
        do {
            $this->elf1->move($this->recipes);
            $this->elf2->move($this->recipes);
            $this->newRecipe();
        } while (count($this->recipes) <= $max);
    }

    public function solve2(array $input)
    {
        //    $this->recipes=[];
        if (!$this->recipes) {
            $this->prepare();
        }

        $this->find = str_split($input[0]);
        foreach ($this->find as &$nums) {
            $nums = (int)$nums;
        }

        $length = count($this->find);

        $key = 0;
        foreach ($this->recipes as $key => $num) {
            $this->find($num);
            if ($this->found === $length) {
                return ($key - $length + 1);
                break;
            }
        }

        do {
            $this->elf1->move($this->recipes);
            $this->elf2->move($this->recipes);
            $newRecipe = $this->newRecipe(true);
            //$key += count($newRecipe);
            foreach ($newRecipe as $num) {
                $key++;
                $this->find($num);
                if ($this->found === $length) {
                    return ($key - $length + 1);
                    break;
                }
            }

        } while (true);
    }

    private function find(int $num)
    {
        if ($num === $this->find[$this->found]) {
            $this->found++;
        } else {
            //reset
            $this->found = 0;
            //check if this is equal to the first
            if ($num === $this->find[0]) {
                $this->found++;
            }
        }
    }

    public function parseInput(array $input)
    {
        // TODO: Implement parseInput() method.
    }
}
