<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4-12-18
 * Time: 6:23
 */

namespace Advent\Y2018\Helper;

class GuardShift
{

    /**
     * @var GuardLog
     */
    private $logs;

    /**
     * @var Sleep[]
     */
    private $sleep;

    private $guardId;

    /**
     * @var Sleep
     */
    private $currentSleep;

    private $totalSleep = 0;
    /**
     * @var array
     */
    private $minutes = [];

    /**
     * @var \DateInterval
     */
    private $interval;

    /**
     * GuardShift constructor.
     *
     * @param $guardId
     */
    public function __construct($guardId)
    {
        $this->guardId = $guardId;

        $this->interval = new \DateInterval('PT1M');
        $this->minutes = array_fill_keys(range(0, 59), 0);
    }

    public function addLog(GuardLog $log)
    {
        /**
         * @var Sleep $sleep
         */
    //    $this->logs[] = $log;

        if ($log->getEvent() === GuardLog::EVENT_FALL_ASLEEP) {
            $this->currentSleep = new Sleep($log->getDate());
        } elseif ($log->getEvent() === GuardLog::EVENT_WAKE_UP) {
            $this->currentSleep->setEnd($log->getDate());
            $this->sleep[] = $this->currentSleep;
            $this->totalSleep += $this->currentSleep->getDuration();
            $this->calcMinutes();
        }
    }

    private function calcMinutes() {
        $period = new \DatePeriod($this->currentSleep->getStart(), $this->interval, $this->currentSleep->getEnd());
        foreach ($period as $minute) {
            $this->minutes[(int)$minute->format('i')]++;
        }
    }
    /**
     * @return array
     */
    public function getMinutes(): array
    {
        return $this->minutes;
    }

    public function getMaxMinute(): array
    {
        arsort($this->minutes);
        $value = reset($this->minutes);

        return [key($this->minutes) => $value];
    }

    /**
     * @return int
     */
    public function getTotalSleep(): int
    {
        return $this->totalSleep;
    }


    /**
     * @return Sleep[]
     */
    public function getSleep(): array
    {
        return $this->sleep;
    }

    /**
     * @return mixed
     */
    public function getGuardId()
    {
        return $this->guardId;
    }


}
