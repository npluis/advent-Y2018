<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4-12-18
 * Time: 6:01
 */

namespace Advent\Y2018\Tests;

use Advent\Y2018\Day\Day5;
use PHPUnit\Framework\TestCase;

class Day5Test extends TestCase
{


    public function inputData()
    {
        return [
            ['aA', 0],
            ['abBA', 0],
            ['abAB', 4],
            ['aabAAB', 6],
            ['dabAcCaCBAcCcaDA', 10],
        ];
    }

    /**
     * @dataProvider inputData
     *
     * @param $input
     * @param $result
     */
    public function testInput($input, $expected)
    {
        $day = new Day5(5);
        $result = $day->solve([$input]);
        $this->assertEquals($expected, $result);
    }

    public function testInput2()
    {
        $day = new Day5(5);
        $result = $day->solve2(['dabAcCaCBAcCcaDA']);
        $this->assertEquals(4, $result);
    }
}
