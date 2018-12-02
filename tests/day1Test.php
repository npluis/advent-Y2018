<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 1-12-18
 * Time: 14:10
 */

namespace Advent\Y2018\Tests;

use Advent\Y2018\Day1;
use PHPUnit\Framework\TestCase;

class Day1Test extends TestCase
{

    public function inputData()
    {
        return [
            ['+1, -2, +3, +1', 3],
            ['+1, +1, +1', 3],
            ['+1, +1, -2', 0],
            ['-1, -2, -3', -6],
        ];
    }

    /**
     * @dataProvider inputData
     * @throws \Exception
     */
    public function testInput($input, $expected)
    {
        $problem = new Day1(1);
        $answer = $problem->solve($input);

        $this->assertEquals($expected, $answer);
    }

    public function inputData2()
    {
        return [
            ['+1,-1', 0],
            ['+3,+3,+4,-2,-4', 10],
            ['-6,+3,+8,+5,-6', 5],
            ['+7,+7,-2,-7,-4', 14],
        ];
    }

    /**
     * @dataProvider inputData2
     * @throws \Exception
     */
    public function testInput2($input, $expected)
    {
        $problem = new Day1(1);
        $answer = $problem->solve2($input);

        $this->assertEquals($expected, $answer);
    }
}
