<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 1-12-18
 * Time: 14:10
 */

namespace Advent\Y2018\Tests;

use Advent\Y2018\Day\Day13;
use Advent\Y2018\Helper\Cart;
use PHPUnit\Framework\TestCase;

class Day13Test extends TestCase
{

    public function inputData()
    {
        return [
            [
                '/->-\        
|   |  /----\
| /-+--+-\  |
| | |  | v  |
\-+-/  \-+--/
  \------/',
                '7,3',
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

        $day = new Day13(13);
        $input = explode("\n", $input);
        $day->parseInput($input);

        $this->assertEquals($day->solve($input), $expected);


    }


    public function inputData2()
    {
        return [
            [
                '\'/>-<\  
|   |  
| /<+-\
| | | v
\>+</ |
  |   ^
  \<->/\'',
                '6,4',
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

        $day = new Day13(13);
        $input = explode("\n", $input);
        $day->parseInput($input);

        $this->assertEquals($day->solve2($input), $expected);


    }

    /**
     * @param $input
     * @param $expected
     *
     * @dataProvider inputMoves
     * @throws \Exception
     */
    public function testMoves($direction, $turn, $expected)
    {

        $cart = new Cart(5, 5, $direction);
        $method = new \ReflectionMethod($cart, 'turn');
        $method->setAccessible(true);
        $newDirection = $method->invokeArgs($cart, [$turn]);

        $this->assertEquals($expected, $newDirection);
    }

    public function inputMoves()
    {
        return
            [
                [Cart::UP, Cart::LEFT, Cart::LEFT],
                [Cart::UP, Cart::RIGHT, Cart::RIGHT],
                [Cart::UP, Cart::STRAIGHT, Cart::UP],
                [Cart::DOWN, Cart::LEFT, Cart::RIGHT],
                [Cart::DOWN, Cart::RIGHT, Cart::LEFT],
                [Cart::DOWN, Cart::STRAIGHT, Cart::DOWN],
                [Cart::LEFT, Cart::LEFT, Cart::DOWN],
                [Cart::LEFT, Cart::RIGHT, Cart::UP],
                [Cart::LEFT, Cart::STRAIGHT, Cart::LEFT],
                [Cart::RIGHT, Cart::LEFT, Cart::UP],
                [Cart::RIGHT, Cart::RIGHT, Cart::DOWN],
                [Cart::RIGHT, Cart::STRAIGHT, Cart::RIGHT],
            ];
    }

}
