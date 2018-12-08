<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 6-12-18
 * Time: 6:07
 */

namespace Advent\Y2018\Helper;

class Coordinate
{
    /**
     * @var int
     */
    private $x;
    /**
     * @var int
     */
    private $y;

    /**
     * @var string
     */
    private $coord;

    private $numClose=0;

    private $finitive=false;



    /**
     * @return bool
     */
    public function isFinitive(): bool
    {
        return $this->finitive;
    }

    /**
     * @param bool $finitive
     */
    public function setFinitive(bool $finitive): void
    {
        $this->finitive = $finitive;
    }



    public function addClosest() {
        $this->numClose++;
    }

    /**
     * @return int
     */
    public function getNumClose(): int
    {
        return $this->numClose;
    }

    private $zeroY=0;
    private $zeroX=0;

    /**
     * Coordinate constructor.
     *
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;

        $this->coord = $x.','.$y;

        $this->zeroX = abs(0-$x);
        $this->zeroY = abs (0-$y);
    }


    private $name='';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * @return string
     */
    public function getCoord(): string
    {
        return $this->coord;
    }


    public function xMultiplier($x) {
        return $x <=> $this->x;
    }

    public function yMultiplier($y) {
        return $y <=> $this->y;
    }

    public function calcDistance($x, $y)
    {
        // return $this->zeroY+($y <=> $this->y)*$y + ($this->zeroX+($x <=> $this->x)*$x);
        return (abs($x - $this->x) + abs($y - $this->y));
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
}
