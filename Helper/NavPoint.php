<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 10-12-18
 * Time: 6:34
 */

namespace Advent\Y2018\Helper;

class NavPoint
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
     * @var int
     */
    private $velocityX;

    /**
     * @var int
     */
    private $veloctityY;

    /**
     * NavPoint constructor.
     *
     * @param int $x
     * @param int $y
     * @param int $velocityX
     * @param int $veloctityY
     */
    public function __construct(int $x, int $y, int $velocityX, int $veloctityY)
    {
        $this->x = $x;
        $this->y = $y;
        $this->velocityX = $velocityX;
        $this->veloctityY = $veloctityY;
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

    /**
     * @return int
     */
    public function getVelocityX(): int
    {
        return $this->velocityX;
    }

    /**
     * @return int
     */
    public function getVeloctityY(): int
    {
        return $this->veloctityY;
    }

    public function calcPosition(int $second): array
    {
        return [$this->x + ($second * $this->velocityX), $this->y + ($second * $this->veloctityY)];
    }

    public function willBeVisible()
    {
        //when will this one be in the range of 0-300
        $range = 400;

        return [
            max(
                ceil((abs($this->x) - $range) / abs($this->velocityX)),
                (ceil((abs($this->y) - $range) / abs($this->veloctityY)))
            ),
            min(
                ceil((abs($this->x) + $range) / abs($this->velocityX)),
                (ceil((abs($this->y) + $range) / abs($this->veloctityY)))
            ),
        ];
    }
}