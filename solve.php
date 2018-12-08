<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 1-12-18
 * Time: 14:35
 */

namespace Advent\Y2018;

use Advent\Y2018\Day\AbstractDayProblem;

require 'vendor/autoload.php';

$longopts = [
    "day:",     // Required value
];
$options = getopt('', $longopts);


$day = $options['day'] ?? $_GET['day'] ?? null;

$class = 'Advent\Y2018\Day\Day'.$day;

if (!class_exists($class)) {
    throw new \Exception(sprintf('Can\'t find class for %d', $day));
}

/**
 * @var AbstractDayProblem $problem
 *
 */

$problem = new $class($day);
$problem->run();

$problem->printAnswers();
