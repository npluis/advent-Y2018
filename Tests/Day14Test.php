<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 1-12-18
 * Time: 14:10
 */

namespace Advent\Y2018\Tests;

use Advent\Y2018\Day\Day14;
use PHPUnit\Framework\TestCase;

class Day14Test extends TestCase
{

    public function inputData()
    {
        return [
            [9, 5158916779,],
            [5, 124515891,],
            [18, 9251071085,],
            [2018, 5941429882,],
        ];
    }

    /**
     * @param $input
     * @param $expected
     *
     * @dataProvider inputData
     * @throws \Exception
     */
    public function testInput($input, $expected)
    {

        $day = new Day14(14);
        $input = explode("\n", $input);
        $day->parseInput([$input]);

        $this->assertEquals($day->solve($input), $expected);


    }

    public function inputData2()
    {


        return [
            [51589,9],
            ['01245',5],
            [92510,18],
            [59414,2018],
        ];
    }

    /**
     * @param $input
     * @param $expected
     *
     * @dataProvider inputData2
     * @throws \Exception
     */
    public function testInput2($input, $expected)
    {

        $day = new Day14(14);
        $input = explode("\n", $input);
        $day->parseInput([$input]);

        $this->assertEquals($day->solve2($input), $expected);


    }
}
