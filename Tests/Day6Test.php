<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4-12-18
 * Time: 6:01
 */

namespace Advent\Y2018\Tests;

use Advent\Y2018\Day\Day5;
use Advent\Y2018\Day\Day6;
use PHPUnit\Framework\TestCase;

class Day6Test extends TestCase
{


    public function inputData()
    {
        return [
            [
                '1, 1
1, 6
8, 3
3, 4
5, 5
8, 9',
                17,
            ],
        ];
    }

    /**
     * @dataProvider inputData
     *
     * @param $input
     * @param $expected
     */
    public function testInput($input, $expected)
    {
        $day = new Day6(6);
        $day->setSafeLimit(32);
        $result = $day->solve(explode("\n",$input));

        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider inputData
     *
     * @param $input
     * @param $expected
     */
    public function testInput2($input, $expected)
    {
        $day = new Day6(6);
        $day->setSafeLimit(32);
        $result = $day->solve2(explode("\n",$input));

        $this->assertEquals(16, $result);
    }

}
