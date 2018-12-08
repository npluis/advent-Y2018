<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 8-12-18
 * Time: 6:08
 */

namespace Advent\Y2018\Helper;

class LicenseNode
{

    /**
     * @var int
     */
    private $numChilds;

    /** @var int */
    private $numMeta;
    /**
     * @var LicenseNode[]
     */
    private $children = [];
    private $metadata = [];

    private $metaSum = 0;

    /**
     * LicenseNode constructor.
     *
     * @param int $numChilds
     * @param int $numMeta
     */
    public function __construct(int $numChilds, int $numMeta)
    {
        $this->numChilds = $numChilds;
        $this->numMeta = $numMeta;
        $this->metadata=new \SplFixedArray($numMeta);
    }


    public function addChild(LicenseNode $node)
    {
        $this->children[] = $node;
    }

    /**
     * @return int
     */
    public function getNumMeta(): int
    {
        return $this->numMeta;
    }

    /**
     * @return LicenseNode[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    public function addMetaData(int $index, int $data)
    {
        $this->metaSum += $data;
        $this->metadata[$index] = $data;
    }

    /**
     * @return int
     */
    public function getNumChilds(): int
    {
        return $this->numChilds;
    }

    /**
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function getRootValue()
    {
        $value = 0;
        if ($this->numChilds === 0) {
            return $this->getMetaSum(false);
        }
        foreach ($this->metadata as $childNum) {
            if (isset($this->children[$childNum-1])) {
                $value += $this->children[$childNum - 1]->getRootValue();
            }

        }
        return $value;
    }

    public function getMetaSum($recursive = true)
    {
        $sum = $this->metaSum;

        if ($recursive) {
            foreach ($this->children as $child) {
                $sum += $child->getMetaSum($recursive);
            }
        }

        return $sum;
    }
}