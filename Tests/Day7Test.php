<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4-12-18
 * Time: 6:01
 */

namespace Advent\Y2018\Tests;

use Advent\Y2018\Day\Day7;
use PHPUnit\Framework\TestCase;

class Day7Test extends TestCase
{

    public function testInput()
    {
        $day = new Day7(7);

        $input =
            'Step C must be finished before step A can begin.
Step C must be finished before step F can begin.
Step A must be finished before step B can begin.
Step A must be finished before step D can begin.
Step B must be finished before step E can begin.
Step D must be finished before step E can begin.
Step F must be finished before step E can begin.';

        $result = $day->solve(explode("\n", $input));

        $this->assertEquals('CABDFE', $result);
    }


    public function testInput2()
    {
        $day = new Day7(7);
        $input = explode(
            "\n",
            'Step C must be finished before step A can begin.
Step C must be finished before step F can begin.
Step A must be finished before step B can begin.
Step A must be finished before step D can begin.
Step B must be finished before step E can begin.
Step D must be finished before step E can begin.
Step F must be finished before step E can begin.'
        );

        $day->createBuiler();
        $day->getBuilder()->setBaseDuration(0);
        $day->getBuilder()->setNumWorkers(2);
        $day->parseInput($input);


        $result = $day->solve2($input);

        $this->assertEquals(15, $result);
        $this->assertEquals('CABFDE', $day->getBuilder()->getDone());
    }

    public function testInput3()
    {
        $day = new Day7(7);
        $day->createBuiler();
        $day->getBuilder()->setBaseDuration(60);
        $day->getBuilder()->setNumWorkers(2);

        $input =
            'Step C must be finished before step A can begin.
Step C must be finished before step F can begin.
Step A must be finished before step B can begin.
Step A must be finished before step D can begin.
Step B must be finished before step E can begin.
Step D must be finished before step E can begin.
Step F must be finished before step E can begin.';

        $result = $day->solve2(explode("\n", $input));

        $this->assertEquals(258, $result);
    }
}
