<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 10-12-18
 * Time: 10:19
 */

namespace Advent\Y2018\Helper;

class OCR
{

    const LINE_HORIZONTAL = 4096;//horizontal line but not at top or bottom
    const LINE_VERTICAL = 8192;
    const MIDDEL_TOP = 4;
    const MIDDEL_BOTTOM = 8;
    const TOP_LEFT = 16;
    const TOP_RIGHT = 32;
    const BOTTOM_LEFT = 64;
    const BOTTOM_RIGHT = 128;
    const TOP_FULL = 256; //full has to be full except for 2, so length should be 4
    const BOTTOM_FULL = 512;
    const LEFT_FULL = 1024; //full vertical left (can be 2 less but lenth should be 8)
    const RIGHT_FULL = 2048; //full vertical left (can be 2 less but lenth should be 8)
    const ALL_CORNERS = 16 + 32 + 64 + 128;

    const MOST_LEFT = 4;
    const MOST_RIGHT = 2;

    private $recognised = [];

    private $letterCharacteristics = [
        'A' => self::BOTTOM_LEFT + self::BOTTOM_RIGHT + self::LINE_HORIZONTAL,
        'B' => self::TOP_LEFT + self::BOTTOM_LEFT + self::BOTTOM_FULL + self::TOP_FULL + self::LEFT_FULL +
            self::LINE_HORIZONTAL,
        'C' => self::TOP_FULL + self::BOTTOM_FULL,
        'D' => self::LEFT_FULL + self::TOP_FULL + self::BOTTOM_FULL,
        'E' => self::TOP_FULL + self::BOTTOM_FULL + self::ALL_CORNERS + self::LEFT_FULL + self::LINE_HORIZONTAL,
        'F' => self::LEFT_FULL + self::TOP_FULL + self::TOP_LEFT + self::TOP_RIGHT + self::BOTTOM_LEFT +
            self::LINE_HORIZONTAL,
        'G' => self::TOP_FULL + self::BOTTOM_RIGHT,
        'H' => self::LINE_HORIZONTAL + self::LEFT_FULL + self::RIGHT_FULL + self::ALL_CORNERS,
        'I' => self::LINE_VERTICAL + self::TOP_LEFT + self::BOTTOM_LEFT,
        'J' => self::TOP_RIGHT,
        'K' => self::TOP_LEFT + self::TOP_RIGHT + self::BOTTOM_RIGHT + self::BOTTOM_LEFT + self::LEFT_FULL,
        'L' => self::LEFT_FULL + self::BOTTOM_FULL + self::BOTTOM_LEFT + self::BOTTOM_RIGHT + self::TOP_LEFT,
        'M' => self::LINE_VERTICAL + self::TOP_RIGHT + self::TOP_LEFT + self::BOTTOM_LEFT + self::BOTTOM_RIGHT,
        'N' => self::LEFT_FULL + self::RIGHT_FULL + self::TOP_LEFT + self::TOP_RIGHT + self::BOTTOM_LEFT +
            self::BOTTOM_RIGHT,
        'O' => 0,
        'P' => self::LEFT_FULL + self::TOP_LEFT + self::BOTTOM_LEFT + self::LINE_HORIZONTAL + self::TOP_FULL,
        'Q' => 0,
        'R' => self::TOP_LEFT + self::TOP_FULL + self::BOTTOM_RIGHT + self::BOTTOM_LEFT + self::LINE_HORIZONTAL +
            self::LEFT_FULL,
        'S' => 0,
        'T' => self::TOP_FULL + self::TOP_LEFT + self::TOP_RIGHT + self::LINE_VERTICAL,
        'U' => self::LEFT_FULL + self::RIGHT_FULL + self::TOP_LEFT + self::TOP_RIGHT + self::BOTTOM_FULL,
        'V' => self::TOP_RIGHT + self::TOP_LEFT + self::MIDDEL_BOTTOM,
        'W' => self::TOP_RIGHT + self::TOP_LEFT,
        'X' => self::TOP_LEFT + self::TOP_RIGHT + self::BOTTOM_RIGHT + self::BOTTOM_LEFT,
        'Y' => self::TOP_LEFT + self::TOP_RIGHT,
        'Z' => self::TOP_LEFT + self::TOP_RIGHT + self::TOP_FULL + self::BOTTOM_FULL + self::BOTTOM_LEFT +
            self::BOTTOM_RIGHT,
    ];


    private $letter = [];
    private $width = 0;
    private $height = 0;
    private $stats = 0;

    public function __construct(array $letter)
    {
        $this->letter = $letter;
        $this->width = strlen($letter[0]);
        $this->height = count($letter);
    }

    public function recognise()
    {
        $this->getCharacteristics();
        $return = [];
        foreach ($this->letterCharacteristics as $proableLetter => $stats) {
            //  echo $proableLetter.'=>'.$stats."\n";
            if ($stats === $this->stats) {
                $return[] = $proableLetter;
            }
        }

        return $return;
    }

    public function getCharacteristics()
    {
        $this->stats = 0;
        $letter = $this->letter;
        $topStat = $this->lineStat(array_shift($letter));
        if ($topStat & self::MOST_RIGHT) {
            $this->recognised[] = "TR";
            $this->stats += self::TOP_RIGHT;
        }
        if ($topStat & self::MOST_LEFT) {
            $this->recognised[] = "TL ";
            $this->stats += self::TOP_LEFT;
        }
        if ($topStat & self::LINE_HORIZONTAL) {
            $this->recognised[] = "TF ";
            $this->stats += self::TOP_FULL;
        }


        $bottomStat = $this->lineStat(array_pop($letter));
        if ($bottomStat & self::MOST_RIGHT) {
            $this->recognised[] = "BR ";
            $this->stats += self::BOTTOM_RIGHT;
        }
        if ($bottomStat & self::MOST_LEFT) {
            $this->recognised[] = "BL ";
            $this->stats += self::BOTTOM_LEFT;
        }
        if ($bottomStat & self::LINE_HORIZONTAL) {
            $this->recognised[] = "BF ";
            $this->stats += self::BOTTOM_FULL;
        }

        foreach ($letter as $line) {
            $stats = $this->lineStat($line);
            if ($stats & self::LINE_HORIZONTAL) {
                $this->recognised[] = 'HL ';
                $this->stats += self::LINE_HORIZONTAL;
                break;
            }
        }

        //check vertical

        $column = array_fill_keys(range(0, $this->width - 1), '');
        foreach ($this->letter as $line) {
            for ($i = 0; $i < $this->width; $i++) {
                $column[$i] .= $line[$i];

            }
        }
        $leftStat = $this->lineStat(array_shift($column), $this->height);
        if ($leftStat & self::LINE_HORIZONTAL) {
            $this->recognised[] = 'LF ';
            $this->stats += self::LEFT_FULL;
        }
        $leftStat = $this->lineStat(array_pop($column), $this->height);
        if ($leftStat & self::LINE_HORIZONTAL) {
            $this->recognised[] = 'RF ';
            $this->stats += self::RIGHT_FULL;
        }


        foreach ($column as $line) {
            $stats = $this->lineStat($line, $this->height);
            if ($stats & self::LINE_HORIZONTAL) {
                $this->recognised[] = 'VL ';
                $this->stats += self::LINE_VERTICAL;
                break;
            }
        }

        // print_r($column);
        return $this->stats;
    }

    private function lineStat($line, $length = null): int
    {
        $stat = 0;
        if (!$length) {
            $length = $this->width - 2;
        }
        //   echo strlen($line);
        if (strpos($line, '  ') === false &&
            strpos($line, '# #') === false &&

            strlen(trim($line)) >= $length &&
            strlen(str_replace(' ', '', $line)) >= $length) {
            $stat += self::LINE_HORIZONTAL;
        }

        if (substr($line, 0, 1) === '#') {
            $stat += self::MOST_LEFT;
        }
        if (substr($line, strlen($line) - 1, 1) === '#') {
            $stat += self::MOST_RIGHT;
        }

        return $stat;
    }

    /**
     * @return array
     */
    public function getRecognised(): array
    {
        return $this->recognised;
    }
}