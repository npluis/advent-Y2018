<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 7-12-18
 * Time: 9:33
 */

namespace Advent\Y2018\Helper;

class ReversedQueue extends \SplPriorityQueue
{
    public function compare($priority1, $priority2)
    {
        return parent::compare($priority2, $priority1);
    }
}
