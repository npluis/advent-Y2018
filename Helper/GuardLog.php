<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4-12-18
 * Time: 6:08
 */

namespace Advent\Y2018\Helper;

class GuardLog
{

    const EVENT_WAKE_UP = 2;
    const EVENT_START_SHIFT = 1;
    const EVENT_FALL_ASLEEP = 3;
    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var int
     */
    private $guard;
    /**
     * @var int
     */
    private $event;

    /**
     * GuardLog constructor.
     *
     * @param      $string
     * @param null $prevGuardId
     *
     * @throws \Exception
     */
    public function __construct($string, $prevGuardId = null)
    {
        $this->date = \DateTime::createFromFormat(
            'Y-m-d H:i',
            substr($string, 1, 16),
            new \DateTimeZone('UTC')
        );
        $pos = strpos($string, 'Guard #');
        if ($pos !== false) {
            $this->guard = (int)substr($string, $pos+7, strpos($string, ' ', $pos));
            $this->event = self::EVENT_START_SHIFT;
        } else {
            $this->guard = $prevGuardId;
            if (strpos($string, 'falls asleep') !== false) {
                $this->event = self::EVENT_FALL_ASLEEP;
            } elseif (strpos($string, 'wakes up') !== false) {
                $this->event = self::EVENT_WAKE_UP;
            } else {
                throw new \Exception('Unknown event '.$string);
            }
        }
    }


    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getGuard(): int
    {
        return $this->guard;
    }

    /**
     * @return int
     */
    public function getEvent(): int
    {
        return $this->event;
    }

}
