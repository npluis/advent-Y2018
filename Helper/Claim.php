<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 3-12-18
 * Time: 8:03
 */

namespace Advent\Y2018\Helper;

class Claim
{

    private $id;
    private $width;
    private $height;

    private $x;
    private $y;

    private $footPrint;

    private $collide;

    public function __construct(string $string)
    {

        $string = str_replace(['#', '@', ':', 'x'], ',', $string);
        $string = explode(',', $string);

        $this->id = (int)$string[1];
        $this->x = (int)$string[2];
        $this->y = (int)$string[3];

        $this->width = (int)$string[4];
        $this->height = (int)$string[5];
    }

    /**
     * @return bool|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    public function getCoord()
    {
        return $this->x.','.$this->y;
    }

    /**
     * @return \Generator
     */
    public function getFootprint()
    {
        if (!$this->footPrint) {
            $footprint = [];
            for ($w = 0; $w < $this->width; $w++) {
                for ($h = 0; $h < $this->height; $h++) {
                    $footprint[($this->x + $w).','.($this->y + $h)] = 1;
                    yield ($this->x + $w).','.($this->y + $h);
                }
            }
            $this->footPrint = $footprint;
        } else {
            foreach (array_keys($this->footPrint) as $coord) {
                yield $coord;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getCollide()
    {
        return $this->collide;
    }

    /**
     * @param bool $collide
     */
    public function setCollide(bool $collide): void
    {
        $this->collide = $collide;
    }
}
