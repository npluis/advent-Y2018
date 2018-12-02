<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 1-12-18
 * Time: 14:22
 */

namespace Advent\Y2018\Day;

abstract class AbstractDayProblem
{

    /**
     * @var int
     */
    protected $day;

    protected $answer1;

    protected $answer2;
    /**
     * @var AdventInput
     */
    protected $input;
    private $timer = [];

    /**
     * AbstractDayProblem constructor.
     *
     * @param $day
     */
    public function __construct(int $day = null)
    {
        if ($day) {
            $this->day = $day;
        }
        $this->input = new AdventInput($this->day);
    }

    public function run()
    {
        $input = $this->input->getInput();
        $time = microtime(true);
        $this->answer1 = $this->solve($input);
        $this->timer[1] = (microtime(true) - $time);

        $time = microtime(true);
        $this->answer2 = $this->solve2($input);
        $this->timer[2] = (microtime(true) - $time);
    }

    abstract public function solve(array $input);

    abstract public function solve2(array $input);

    public function printAnswers()
    {
        echo PHP_EOL;
        for ($d = 1; $d <= 2; $d++) {
            printf("\033[32m Problem %d:\033[0m %s ".PHP_EOL, $d, $this->getAnswer($d));
            printf("\033[32m solved in :\033[0m %fs ".PHP_EOL.PHP_EOL, $this->timer[$d]);
            echo PHP_EOL;
        }
    }

    /**
     * @param int $problem
     *
     * @return mixed
     */
    public function getAnswer(int $problem)
    {
        switch ($problem) {
            case 1:
                return $this->answer1;
                break;
            case 2:
                return $this->answer2;
                break;
            default:
                throw new \InvalidArgumentException('invalid problem '.$problem);
        }
    }
}
