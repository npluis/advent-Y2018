<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4-12-18
 * Time: 6:24
 */

namespace Advent\Y2018\Helper;

class Sleep
{
    /**
     * @var \DateTime
     */
    private $start;

    /**
     * @var \DateTime
     */
    private $end;

    /**
     * @var int
     */
    private $duration;

    /**
     * Sleep constructor.
     *
     * @param \DateTime $start
     */
    public function __construct(\DateTime $start)
    {
        $this->start = $start;
    }

    /**
     * @return \DateTime
     */
    public function getStart(): \DateTime
    {
        return $this->start;
    }


    /**
     * @return \DateTime
     */
    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    /**
     * @param \DateTime $end
     */
    public function setEnd(\DateTime $end): void
    {
        $this->end = $end;
        $diff = $this->start->diff($end);
        $diffMinutes = (int) $diff->format('%d') * (24 * 60);
        $diffMinutes += (int) $diff->format('%h') * 60;
        $diffMinutes += (int) $diff->format('%i');
        $this->setDuration($diffMinutes);
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }
}