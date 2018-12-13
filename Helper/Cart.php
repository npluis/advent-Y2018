<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 13-12-18
 * Time: 6:05
 */

namespace Advent\Y2018\Helper;

class Cart
{

    const UP = -1;
    const RIGHT = 10;
    const DOWN = 1;
    const LEFT = -10;


    const STRAIGHT = 99;
    const MOVES = [
        // |
        124 => [0, 1, self::DOWN],
        -124 => [0, -1, self::UP],

        // -
        450 => [1, 0, self::RIGHT],
        -450 => [-1, 0, self::LEFT],

        // /
        47 => [-1, 0, self::LEFT],
        -47 => [1, 0, self::RIGHT],
        470 => [0, -1, self::UP],
        -470 => [0, 1, self::DOWN],

        // \
        92 => [1, 0, self::RIGHT],
        -92 => [-1, 0, self::LEFT],
        920 => [0, 1, self::DOWN],
        -920 => [0, -1, self::UP],

        // +
        43 => [0, 1, self::DOWN],
        -43 => [0, -1, self::UP],
        430 => [1, 0, self::RIGHT],
        -430 => [-1, 0, self::LEFT],
    ];
    /**
     * $diff = ($this->direction <=> 0) * ceil(abs($this->direction) / 10);
    //   echo " new direction {$this->direction} ($diff)";
    switch ($this->direction) {
    case self::UP:
    case self::DOWN:
    $this->y += $diff;
    break;
    default:
    $this->x += $diff;
    }
     */

    const TURN_ORDER = [self::LEFT, self::STRAIGHT, self::RIGHT];
    public $y = 0;
    private $x = 0;
    private $direction;
    private $turns = 0;

    public function __construct(int $x, int $y, $direction)
    {
        $this->x = $x;
        $this->y = $y;
        $this->direction = $direction;
    }


    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    public function getCoord(): array
    {
        return [$this->x, $this->y];
    }

    /**
     * @return mixed
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param array $grid
     *
     * @throws \Exception
     */
    public function move(array $grid)
    {

        $cell = $grid[$this->y][$this->x];


        if ($cell === 43) {
            $turn = self::TURN_ORDER[$this->turns++ % 3];
            $this->turn($turn);
        }


        $move = self::MOVES[$cell * $this->direction];
        $this->x += $move[0];
        $this->y += $move[1];
        $this->direction = $move[2];

        return;


//        echo "=> \t[$this->x,$this->y] . @{$this->direction}";
    }


    private function turn($direction): int
    {
        if ($direction === self::STRAIGHT) {
            return $this->direction;
        }
        switch ($this->direction) {
            case self::UP:
                $this->direction = $direction;

                return $direction;
                break;
            case self::DOWN:
                $this->direction = $direction * -1;
                break;
            case self::RIGHT:
                $this->direction = $direction / 10;
                break;
            case self::LEFT:
                $this->direction = $direction / -10;
                break;
        }

        return $this->direction;
    }
}