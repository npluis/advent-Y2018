<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 12-12-18
 * Time: 6:27
 */

namespace Advent\Y2018\Day;

use Advent\Y2018\Helper\Cart;
use Advent\Y2018\Helper\ReversedQueue;

class Day13 extends AbstractDayProblem
{

    protected $trim = false;
    private $grid = [];
    /**
     * @var Cart[]
     */
    private $carts = [];
    private $basePriority = 0;

    public function solve(array $input)
    {
        if (!$this->grid) {
            $this->parseInput($input);
        }


        $result= $this->runCarts(false);

        return $result;
    }

    public function parseInput(array $input)
    {

        //round to base 10
        $this->basePriority = 10 ** ceil(log(count($input), 10));
        $this->carts = [];
        $this->grid = [];
        $y = 0;
        foreach ($input as $line) {
            $x = 0;
            foreach (str_split($line) as $char) {
                switch ($char) {
                    //  case ' ':
                    //      continue;
                    default:
                        $this->grid[$y][$x] = ord($char);
                        break;
                    case '>':
                        $this->grid[$y][$x] = ord('-');
                        $this->carts[] = new Cart($x, $y, Cart::RIGHT);
                        break;
                    case '<':
                        $this->grid[$y][$x] = ord('-');
                        $this->carts[] = new Cart($x, $y, Cart::LEFT);
                        break;
                    case '^':
                        $this->grid[$y][$x] = ord('|');
                        $this->carts[] = new Cart($x, $y, Cart::UP);
                        break;
                    case 'v':
                        $this->grid[$y][$x] = ord('|');
                        $this->carts[] = new Cart($x, $y, Cart::DOWN);
                        break;
                }
                $x++;
            }
            $y++;
        }
    }

    public function solve2(array $input)
    {


        $this->parseInput($input);


        return $this->runCarts(true);
    }

    private function runCarts($remove = false)
    {

        $collided = false;
        $positions = [];
        foreach ($this->carts as $cartKey => $cart) {
            $positions[$cartKey] = $cart->getX().",".$cart->getY();
        }

        do {
            uasort(
                $this->carts,
                function (Cart $a, Cart $b) {
                    return ($a->getY() <=> $b->getY()) ?? ($a->getX() <=> $b->getX());
                }
            );

            foreach ($this->carts as $cartKey => $cart) {
                /**
                 * @var Cart $cart
                 */
                if (!isset($positions[$cartKey])) {
                    //already crashed
                    continue;
                }

                $cart->move($this->grid);
                $coord = implode(',', $cart->getCoord());

                if (in_array($coord, $positions)) {
                    $collidingCart = array_search($coord, $positions);
                    if ($remove) {
                        unset($this->carts[$cartKey], $this->carts[$collidingCart]);
                        unset($positions[$cartKey], $positions[$collidingCart]);
                    } else {
                        $collided = true;
                        break;
                    }
                } else {
                    $positions[$cartKey] = $coord;
                }
            }

            if ($remove && count($this->carts) <= 1) {
                $collided = true;
            }


        } while ($collided === false);

        return $coord;
    }
}
