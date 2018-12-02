<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 1-12-18
 * Time: 14:22
 */

namespace Advent\Y2018;

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
        $input = trim($this->input->getInput());
        $this->answer1 = $this->solve($input);

        $this->answer2 = $this->solve2($input);
    }

    abstract public function solve(string $input);

    abstract public function solve2(string $input);

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
                throw new \InvalidArgumentException('invalid problem '. $problem);
        }
    }
}
