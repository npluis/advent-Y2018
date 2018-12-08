<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4-12-18
 * Time: 6:01
 */

namespace Advent\Y2018\Tests;

use Advent\Y2018\Day\Day8;
use PHPUnit\Framework\TestCase;

class Day8Test extends TestCase
{

    public function testInput()
    {
        $day = new Day8(8);

        $input =['2 3 0 3 10 11 12 1 1 0 1 99 2 1 1 2'];

        $result = $day->solve($input);

        $this->assertEquals(138, $result);

        if (file_exists('./cache/day8.txt')) {
            $day = new Day8(8);
            $input = file_get_contents('./cache/day8.txt');
            $result = $day->solve([$input]);
            $this->assertEquals(48155, $result);
        }


    }

    public function testInput2()
    {
        $day = new Day8(8);

        $input =['2 3 0 3 10 11 12 1 1 0 1 99 2 1 1 2'];

        $result = $day->solve2($input);

        $this->assertEquals(66, $result);
    }
}
