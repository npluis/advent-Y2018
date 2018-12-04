<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4-12-18
 * Time: 6:02
 */

namespace Advent\Y2018\Day;

use Advent\Y2018\Helper\GuardLog;
use Advent\Y2018\Helper\GuardShift;

class Day4 extends AbstractDayProblem
{
    protected $day = 4;

    /**
     * @var GuardLog[]
     */
    private $logs;

    /**
     * @var GuardShift[]
     */
    private $shifts;

    public function solve(array $input)
    {
        uasort(
            $this->shifts,
            function (GuardShift $shift, GuardShift $shift2) {
                return $shift->getTotalSleep() < $shift2->getTotalSleep() ? 1 : 0;
            }
        );

        //get first one
        $shift = reset($this->shifts);
        $minute = $shift->getMaxMinute();
        $most = key($minute);

        return $most * $shift->getGuardId();
    }

    public function solve2(array $input)
    {
        if (!$this->shifts) {
            $this->parseInput($input);
        }

        $maxCount = 0;
        $maxMinute = 0;
        $guard = 0;
        foreach ($this->shifts as $shift) {
            $minutes = $shift->getMaxMinute();
            $value = reset($minutes);
            if ($value > $maxCount) {
                $maxCount = $value;
                $maxMinute = key($minutes);
                $guard = $shift->getGuardId();
            }
        }

        return $guard * $maxMinute;
    }

    public function parseInput(array $input)
    {

        $guardId = 0;
        sort($input);
        foreach ($input as $logLine) {
            $log = new GuardLog($logLine, $guardId);
            $newId = $log->getGuard();
            if ($guardId !== $newId) {
                if (isset($this->shifts[$newId])) {
                    $shift = $this->shifts[$newId];
                } else {
                    $shift = new GuardShift($newId);
                    $this->shifts[$newId] = $shift;
                }
            }
            $shift->addLog($log);
            $guardId = $log->getGuard();
            $this->logs[] = $log;
        }
    }
}
