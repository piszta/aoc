<?php

function search1(array $rows, int $x, int $y, string $string): int
{
    $sum = 0;

    for ($i = -1; $i <= 1; $i++) {
        for ($j = -1; $j <= 1; $j++) {
            for ($c = 0; $c < strlen($string); $c++) {
                if (($rows[$y + ($c * $i)][$x + ($c * $j)] ?? null) != $string[$c]) {
                    break;
                }
            }

            $sum += (int) $c == strlen($string);
        }
    }

    return $sum;
}

function search2(array $rows, int $x, int $y, string $string): int
{
    $sum = 0;

    for ($i = -1; $i <= 1; $i = $i + 2) {
        for ($j = -1; $j <= 1; $j = $j + 2) {
            for ($c = 0; $c < strlen($string); $c++) {
                if (($rows[$y + ($c * $i) - $i][$x + ($c * $j) - $j] ?? null) != $string[$c]) {
                    break;
                }
            }

            $sum += (int) $c == strlen($string);
        }
    }

    return (int) $sum / 2;
}

// ---

$rows = file(str_replace('.php', '.input.txt', __FILE__));

$sum1 = 0;
$sum2 = 0;

for ($y = 0; $y < count($rows); $y++) {
    for ($x = 0; $x < strlen($rows[$y]); $x++) {
        $sum1 += search1($rows, $x, $y, 'XMAS');
        $sum2 += search2($rows, $x, $y, 'MAS');
    }
}

echo "step 1: $sum1\n";
echo "step 2: $sum2\n";
