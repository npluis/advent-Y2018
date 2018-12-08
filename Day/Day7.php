<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 7-12-18
 * Time: 7:09
 */

namespace Advent\Y2018\Day;

use Advent\Y2018\Helper\Builder;

class Day7 extends AbstractDayProblem
{

    /**
     * @var Builder
     */
    private $builder;

    private $workers = 5;
    private $baseDuration = 60;



    public function solve(array $input)
    {
        $this->parseInput($input);
        $string = '';
        while ($next = $this->builder->getNextStep()) {
            $string .= $next->getName();
            $this->builder->removeStep($next);
        }

        return $string;
    }

    public function createBuiler()
    {
        $this->builder = new Builder();
    }

    public function parseInput(array $input)
    {
        if (!$this->builder) {
            $this->builder = new Builder();
        }
        //Step L must be finished before step M can begin.
        foreach ($input as $string) {
            $nextStep = $this->builder->getStep(substr($string, 36, 1));
            $prevStep = $this->builder->getStep(substr($string, 5, 1));

            $nextStep->addPrevStep($prevStep);
        }
    }

    /**
     * @param int $workers
     */
    public function setWorkers(int $workers): void
    {
        $this->workers = $workers;
    }

    /**
     * @param int $baseDuration
     */
    public function setBaseDuration(int $baseDuration): void
    {
        $this->baseDuration = $baseDuration;
    }


    public function solve2(array $input)
    {

        if (!$this->builder) {
            $this->builder = new Builder();
        }


        $this->parseInput($input);
        $done='';
        $time = 0;
        $this->builder->setElapsedTime($time);
        do {
            $steps = $this->builder->getAvailableSteps();

            while (count($steps) > 0) {
                $worker = $this->builder->nextFreeWorker();
                if (!$worker) {
                    //no one available
                    break;
                }
                $worker->start(array_shift($steps), $time);
                $this->builder->startWorker($worker);
            }

            //next worker free

            $worker = $this->builder->finishFirstWorker();
            $done .=$worker->getLastStep()->getName();
            $time = $worker->getElapsedTime();

        } while ($this->builder->hasSteps());

        return $time;
    }

    /**
     * @return Builder
     */
    public function getBuilder(): Builder
    {
        return $this->builder;
    }
}
