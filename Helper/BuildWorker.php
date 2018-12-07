<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 7-12-18
 * Time: 8:33
 */

namespace Advent\Y2018\Helper;

class BuildWorker
{

    private $free = true;

    private $endTime = 0;

    /**
     * @var BuildStep
     */
    private $step;

    private $id;

    private $totalTime = 0;
    private $startTime = 0;

    private $elapsedTime = 0;
    /**
     * @var BuildStep
     */
    private $lastStep;

    /**
     * BuildWorker constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function start(BuildStep $step, int $time)
    {
        /*
        echo "Starting ".$step->getName()." on worker ".$this->id." will take ".
            $step->getDuration()." now ".$time."\n";
        */
        $this->startTime = $time;
        $this->step = $step;
        $this->endTime = $time + $step->getDuration();
    }

    /**
     * @return BuildStep
     */
    public function getStep(): BuildStep
    {
        return $this->step;
    }

    /**
     * @return int
     */
    public function getElapsedTime(): int
    {
        return $this->elapsedTime;
    }

    /**
     * @return BuildStep
     */
    public function getLastStep(): BuildStep
    {
        return $this->lastStep;
    }

    public function end()
    {
        /*
        echo sprintf(
            "finish step %s, on worker %d, started %d, should take %d, now %d\n",
            $this->step->getName(),
            $this->id,
            $this->startTime,
            $this->step->getDuration(),
            $this->startTime + $this->step->getDuration()
        );
        */
        $this->lastStep = $this->step;
        $this->elapsedTime = $this->startTime + $this->step->getDuration();
        $this->startTime = 0;
        $this->totalTime += $this->step->getDuration();
        $this->step = null;
        $this->free = true;
        $this->endTime = null;
    }

    /**
     * @return int
     */
    public function getEndTime(): int
    {
        return $this->endTime;
    }


    /**
     * @param int $time
     *
     * @return bool
     */
    public function isFree(int $time)
    {
        return $this->free || ($time > $this->endTime);
    }
}
