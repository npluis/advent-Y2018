<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 1-12-18
 * Time: 14:20
 */

namespace Advent\Y2018;


class AdventInput
{

    const URL = 'https://adventofcode.com/2018/day/';
    private $day;

    /**
     * AdventInput constructor.
     *
     * @param $day
     */
    public function __construct($day)
    {
        $this->day = $day;
    }

    public function getInput()
    {
        $file = './cache/day'.$this->day.'.txt';
        if (!file_exists($file)) {
            file_put_contents($file, file_get_contents(self::URL.$this->day.'/input'));
        }

        return file_get_contents($file);
    }
}