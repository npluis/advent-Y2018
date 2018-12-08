<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 8-12-18
 * Time: 6:03
 */

namespace Advent\Y2018\Day;

use Advent\Y2018\Helper\LicenseNode;

class Day8 extends AbstractDayProblem
{
    /**
     * @var LicenseNode[]
     */
    private $nodes = [];

    private $totalMeta = 0;

    /**
     * @var \SplStack
     */
    private $nums;

    public function __construct(int $day = null)
    {
        parent::__construct($day);
    }


    public function solve(array $input)
    {
        if (!$this->nodes) {
            $this->parseInput($input);
        }

        $sum = 0;
        foreach ($this->nodes as $node) {
            $sum += $node->getMetaSum();
        }

        return $this->totalMeta;
    }

    public function parseInput(array $input)
    {
        $this->nums = new \SplStack();
        $nums = explode(" ", trim($input[0]));
        foreach ($nums as $num) {
            $this->nums->push($num);
        }
        do {
            $node = $this->extractNode();
            $this->extractChild($node);
            $this->extractMeta($node);
            $this->nodes[] = $node;
        } while ($this->nums->count() > 0);

        //   print_r($this->nodes);
    }

    private function extractNode()
    {
        $numChilds = $this->nums->shift();
        $numMeta = $this->nums->shift();

        $node = new LicenseNode($numChilds, $numMeta);

        return $node;
    }

    private function extractChild(LicenseNode $parent)
    {
        $numChilds = $parent->getNumChilds();
        for ($i = 0; $i < $numChilds; $i++) {
            $child = $this->extractNode();
            $parent->addChild($child);
            if ($child->getNumChilds() > 0) {
                $this->extractChild($child);
            }
            $this->extractMeta($child);
        }
    }

    private function extractMeta(LicenseNode $parent)
    {
        $numMeta = $parent->getNumMeta();
        for ($i = 0; $i < $numMeta; $i++) {
            $meta = $this->nums->shift();
            $this->totalMeta += $meta;
            $parent->addMetaData($i,$meta);
        }
    }

    public function solve2(array $input)
    {
        if (!$this->nodes) {
            $this->parseInput($input);
        }

        $root = reset($this->nodes);

        return $root->getRootValue();
    }
}
