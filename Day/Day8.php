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

    private $totalMeta=0;

    public function solve(array $input)
    {
        if (!$this->nodes) {
            $this->parseInput($input);
        }

        $sum =0;
        foreach ($this->nodes as $node) {
            echo "root " . $node->getNumChilds() . ',' . $node->getNumMeta() . "\n";
            $sum += $node->getMetaSum();
        }

        echo "SUM: $sum . count" . count($this->nodes);
        return $this->totalMeta;
    }

    public function parseInput(array $input)
    {
        echo "parsing.....";
        $nums = explode(" ", trim($input[0]));
        do {
            $node = $this->extractNode($nums);
            $this->extractChild($node, $nums);
            $this->extractMeta($node, $nums);
            $this->nodes[] = $node;
        } while (count($nums) > 0);

     //   print_r($this->nodes);
    }

    private function extractNode(array &$nums)
    {

        $numChilds = array_shift($nums);
        $numMeta = array_shift($nums);

        $node = new LicenseNode($numChilds, $numMeta);

        return $node;
    }

    private function extractChild(LicenseNode $parent, array &$nums)
    {
      //  echo "childs: ".$parent->getNumChilds()."\n";
        for ($i = 0; $i < $parent->getNumChilds(); $i++) {
            $child = $this->extractNode($nums);

            $parent->addChild($child);
            if ($child->getNumChilds() > 0) {
                $this->extractChild($child, $nums);
            }
            $this->extractMeta($child, $nums);
        }
    }

    private function extractMeta(LicenseNode $parent, array &$nums)
    {
      //  printf("meta for node with %d children and %d meta\n", $parent->getNumChilds(), $parent->getNumMeta());
        for ($i = 0; $i < $parent->getNumMeta(); $i++) {
            $meta = array_shift($nums);
       //     echo "meta " . $meta ."\n";
            $this->totalMeta+=$meta;
            $parent->addMetaData($meta);
        }
    }

    public function solve2(array $input)
    {
        if (!$this->nodes) {
            $this->parseInput($input);
        }

        $root = reset($this->nodes);
        echo $root->getNumChilds() . "," . $root->getNumMeta() . "\n";
        print_r($root->getMetadata());
        return $root->getRootValue();
    }
}