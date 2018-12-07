<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 7-12-18
 * Time: 7:21
 */

namespace Advent\Y2018\Helper;

class BuildStep
{

    private $name;
    private $prevSteps;

    private $baseDuration = 60;
    private $duration = 0;
    private $startTime = null;

    private $parallel=false;

    /**
     * @param bool $parallel
     */
    public function setParallel(bool $parallel): void
    {
        $this->parallel = $parallel;
    }

    /**
     * BuildStep constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->prevSteps = [];
        $this->duration = $this->baseDuration + ord($name) - 64;
    }

    /**
     * @param int $baseDuration
     */
    public function setBaseDuration(int $baseDuration): void
    {
        $this->duration = $this->duration - $this->baseDuration + $baseDuration;
        $this->baseDuration = $baseDuration;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getElapsedTimeOnFinish()
    {
        return $this->duration - $this->startTime;
    }

    /**
     * @param int $startTime
     */
    public function setStartTime(int $startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return bool
     */
    public function isParallel(): bool
    {
        return $this->parallel;
    }


    /**
     * @return int
     */
    public function getNumPrevSteps(): int
    {
        return count($this->prevSteps);
    }

    public function removeStep(BuildStep $step)
    {
        unset($this->prevSteps[$step->getName()]);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function addPrevStep(BuildStep $step)
    {
        $this->prevSteps[$step->getName()] = $step;
    }

    /**
     * @return int|null
     */
    public function getStartTime()
    {
        return $this->startTime;
    }
}
