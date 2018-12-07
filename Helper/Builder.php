<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 7-12-18
 * Time: 8:02
 */

namespace Advent\Y2018\Helper;

class Builder
{

    /**
     * @var BuildStep[]
     */
    private $allSteps = [];

    private $numWorkers = 5;

    private $baseDuration = 60;
    private $done = '';
    /**
     * @var ReversedQueue
     */
    private $activeWorkers;

    private $freeWorkers = [];

    private $elapsedTime = 0;

    public function __construct()
    {
        $this->activeWorkers = new ReversedQueue();
        $this->activeWorkers->setExtractFlags(ReversedQueue::EXTR_BOTH);
        $this->initWorkers();
    }

    private function initWorkers()
    {
        $this->freeWorkers = [];
        for ($i = 1; $i <= $this->numWorkers; $i++) {
            $this->freeWorkers[] = new BuildWorker($i);
        }
    }

    /**
     * @param int $baseDuration
     */
    public function setBaseDuration(int $baseDuration): void
    {
        $this->baseDuration = $baseDuration;
    }

    /**
     * @param int $workers
     */
    public function setNumWorkers(int $workers): void
    {

        $this->numWorkers = $workers;
        $this->initWorkers();
    }

    public function startWorker(BuildWorker $worker)
    {
        $time = $worker->getEndTime();
        $this->activeWorkers->insert($worker, $time);
        unset($this->allSteps[$worker->getStep()->getName()]);
    }

    /**
     * @return string
     */
    public function getDone(): string
    {
        return $this->done;
    }

    /**
     * @param int $elapsedTime
     */
    public function setElapsedTime(int $elapsedTime): void
    {
        $this->elapsedTime = $elapsedTime;
    }


    /**
     * @return BuildWorker|null
     */
    public function nextFreeWorker(): ?BuildWorker
    {
        return array_shift($this->freeWorkers);
    }

    /**
     * @param $stepName
     *
     * @return BuildStep
     */
    public function getStep($stepName)
    {
        if (!isset($this->allSteps[$stepName])) {
            $step = new BuildStep($stepName);
            $step->setBaseDuration($this->baseDuration);
            $this->allSteps[$stepName] = $step;
        }

        return $this->allSteps[$stepName];
    }

    /**
     * @return bool
     */
    public function hasSteps()
    {
        return count($this->allSteps) > 0;
    }

    /**
     * @return bool|BuildStep
     */
    public function getNextStep()
    {
        if (count($this->allSteps) === 0) {
            return false;
        }

        $this->sortSteps();

        return reset($this->allSteps);
    }

    private function sortSteps()
    {
        uasort(
            $this->allSteps,
            [self::class, 'sorter']
        );
    }

    /**
     * @return BuildStep[]
     */
    public function getAvailableSteps()
    {
        $steps = array_filter(
            $this->allSteps,
            function (BuildStep $step) {
                return ($step->getNumPrevSteps() === 0 && $step->getStartTime() === null);
            }
        );
        uasort(
            $steps,
            [self::class, 'sorter']
        );

        return $steps;
    }

    /**
     *
     * @return BuildWorker|null
     */
    public function finishFirstWorker()
    {
        /**
         * @var BuildWorker $worker
         */
        $worker = null;
        $data = $this->activeWorkers->extract();
        if (isset($data['data'])) {
            $worker = $data['data'];
        } else {
            return null;
        }

        $step = $worker->getStep();

        $this->removeStep($step);
        $worker->end();

        $this->freeWorkers[] = $worker;

        return $worker;
    }


    public function removeStep(BuildStep $step)
    {
        echo "removing ".$step->getName()."\n";
        $this->done .= $step->getName();
        foreach ($this->allSteps as $otherStep) {
            $otherStep->removeStep($step);
        }

        unset($this->allSteps[$step->getName()]);
    }

    /**
     * @return bool
     */
    public function hasFreeWorker()
    {
        return count($this->freeWorkers);
    }

    private function sorter(BuildStep $stepA, BuildStep $stepB)
    {
        $order = ($stepA->getNumPrevSteps() <=> $stepB->getNumPrevSteps());

        if ($order === 0) {
            $order = $stepA->getName() <=> $stepB->getName();
        }

        return $order;
    }
}
