<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 1-12-18
 * Time: 14:35
 */

namespace Advent\Y2018;

require 'vendor/autoload.php';

$longopts = [
    "day:",     // Required value
];
$options = getopt('', $longopts);


$day = $options['day'];
$class = 'Advent\Y2018\Day'.$day;
$problem = new $class();

if (!class_exists($class)) {
    throw new \Exception(sprintf('Can\'t find class for %d', $day));
}

/**
 * @var AbstractDayProblem $problem
 *
 */

$problem = new $class();
$problem->run();

echo "\nSOLVED 1\n";
echo $problem->getAnswer(1);
echo "\n\n";

echo "\nSOLVED 2\n";
echo $problem->getAnswer(2);
echo "\n\n";