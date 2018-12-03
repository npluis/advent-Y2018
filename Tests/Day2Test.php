<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 1-12-18
 * Time: 14:10
 */

namespace Advent\Y2018\Tests;

use Advent\Y2018\Day\Day2;
use PHPUnit\Framework\TestCase;

class Day2Test extends TestCase
{

    public function inputDataChecksum()
    {
        return [
            ['abcdef', [0, 0]],
            ['bababc', [1, 1]],
            ['abbcde', [1, 0]],
            ['abcccd', [0, 1]],
            ['aabcdd', [1, 0]],
            ['abcdee', [1, 0]],
            ['ababab', [0, 1]],
        ];
    }

    /**
     * @param $input
     * @param $expected
     *
     * @dataProvider inputDataChecksum
     * @throws \Exception
     */
    public function testChecksum($input, $expected)
    {
        $problem = new Day2();
        $reflection = new \ReflectionClass($problem);
        $reflectionMethod = $reflection->getMethod('checksumBox');
        $reflectionMethod->setAccessible(true);
        $answer = $reflectionMethod->invokeArgs($problem, [$input]);

        $this->assertEquals($expected, $answer);
    }

    public function inputData()
    {
        return [
            [
                "abcdef\n
            bababc\n
            abbcde\n
            abcccd\n
            aabcdd\n
            abcdee\n
            ababab",
                12,
            ],
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
        $problem = new Day2();
        $answer = $problem->solve(explode("\n", $input));

        $this->assertEquals($expected, $answer);
    }

    public function inputData2()
    {
        return [
            [
                [
                    'abcde',
                    'fghij',
                    'klmno',
                    'pqrst',
                    'fguij',
                    'axcye',
                    'wvxyz',
                ],
                'fgij',
            ],
            [
                [
                    'abcde',
                    'fghij',
                    'klmno',
                    'pqrst',
                    'fghka',
                    'fguij',
                    'axcye',
                    'wvxyz',
                ],
                'fgij',
            ],

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
        $problem = new Day2();
        $answer = $problem->solve2($input);

        $this->assertEquals($expected, $answer);
    }
}
