<?php

$time = microtime(true);
$InputFile = "./cache/day5.txt";

$units = trim(file_get_contents($InputFile));

function react_str_replace(string $units, string $exclude = null): string
{
    if ($exclude) {
        $units = str_replace([$exclude, strtoupper($exclude)], '', $units);
    }

    $len = strlen($units);
    $i = 0;

    while ($i < $len - 1) {
        if (abs(ord($units[$i]) - ord($units[$i + 1])) === 32) {
            $units = substr($units, 0, $i) . substr($units, $i + 2);
            if ($i) {
                $i--;
            }
            $len -= 2;
        } else {
            $i++;
        }
    }

    return $units;
}
$sub = microtime(true);

$part1 = react_str_replace($units);
echo "Part 1: " . strlen($part1) . PHP_EOL;
echo (microtime(true)-$sub) *1000 . 'ms' . PHP_EOL;
//$sub = microtime(true);

$part1 = react_str_replace($units);
$smallest = strlen($part1);

$sum = 0;
$count = 0;

for ($x = ord('a'); $x <= ord('z'); $x++) {
    $letter = chr($x);

    $reacted = strlen(react_str_replace($part1, $letter));

    $sum += $reacted;
    $count++;

    if ($reacted < $smallest) {
        $smallest = $reacted;
    }

    if ($reacted < ($sum / $count) * 0.8) {
        // This one is more than 20% smaller, which qualifies as 'significantly' as stated in the assignment, so we cancel out here.
        break;
    }
}

echo "Part 2: " . $smallest . PHP_EOL;
//echo (microtime(true)-$sub) *1000 . 'ms' . PHP_EOL;

echo "total: " . (microtime(true)-$time) *1000 . 'ms' . PHP_EOL;
