<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 1-12-18
 * Time: 14:10
 */

namespace Advent\Y2018\Tests;

use Advent\Y2018\Day\Day2;
use Advent\Y2018\Day\Day3;
use Advent\Y2018\Helper\Claim;
use PHPUnit\Framework\TestCase;

class Day3Test extends TestCase
{


    public function testClaim()
    {
        $string = '#1 @ 2,3: 4x5';
        $claim1 = new Claim($string);
        $this->assertEquals(1, $claim1->getId());
        $this->assertEquals(2, $claim1->getX());
        $this->assertEquals(3, $claim1->getY());
        $this->assertEquals(4, $claim1->getWidth());
        $this->assertEquals(5, $claim1->getHeight());

        $string = '#123 @ 3,2: 5x4';
        $claim = new Claim($string);
        $this->assertEquals(123, $claim->getId());
        $this->assertEquals(3, $claim->getX());
        $this->assertEquals(2, $claim->getY());
        $this->assertEquals(5, $claim->getWidth());
        $this->assertEquals(4, $claim->getHeight());

        $footprint = [
            '3,2' => 1,
            '3,3' => 1,
            '3,4' => 1,
            '3,5' => 1,
            '4,2' => 1,
            '4,3' => 1,
            '4,4' => 1,
            '4,5' => 1,
            '5,2' => 1,
            '5,3' => 1,
            '5,4' => 1,
            '5,5' => 1,
            '6,2' => 1,
            '6,3' => 1,
            '6,4' => 1,
            '6,5' => 1,
            '7,2' => 1,
            '7,3' => 1,
            '7,4' => 1,
            '7,5' => 1,
        ];

print_r($claim->getnewFootPrint());
print_r($claim1->getnewFootPrint());
print_r($this->array_merge_recursive_new($claim->getnewFootPrint(), $claim1->getnewFootPrint()));die();
        foreach ($claim->getFootprint() as $coord) {
            $actual[$coord]=1;
        }
        $this->assertEquals($footprint, $actual);
    }

    /**
     * Version of array_merge_recursive without overwriting numeric keys
     *
     * @param  array $array1 Initial array to merge.
     * @param  array ...     Variable list of arrays to recursively merge.
     *
     * @link   http://www.php.net/manual/en/function.array-merge-recursive.php#106985
     * @author Martyniuk Vasyl <martyniuk.vasyl@gmail.com>
     */
    public function array_merge_recursive_new()
    {
        $output = array();
        foreach(func_get_args() as $array) {
            foreach($array as $key => $value) {
                $output[$key] = isset($output[$key]) ?
                    $this->array_merge_recursive_new($output[$key], $value) : $value;
            }
        }
        return $output;
    }

    public function inputData()
    {
        return [
            [
                '#1 @ 1,3: 4x4
              #2 @ 3,1: 4x4
              #3 @ 5,5: 2x2',
                4,
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
        $problem = new Day3(3);
        $answer = $problem->solve(explode("\n", $input));

        $this->assertEquals($expected, $answer);
    }


    /**
     * @param $input
     * @param $expected
     *
     *
     * @throws \Exception
     */
    public function testInput2()
    {
        $problem = new Day3();
        $input = [
            '#1 @ 1,3: 4x4',
            '#2 @ 3,1: 4x4',
            '#3 @ 5,5: 2x2',
        ];

        $answer = $problem->solve2($input);
        $this->assertEquals(3, $answer);


    }
}
