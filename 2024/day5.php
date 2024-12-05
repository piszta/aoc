<?php

$input = trim(file_get_contents(str_replace('.php', '.input.txt', __FILE__)));
$pairs = array_map(function ($item) { return explode('|', $item); }, explode("\n", substr($input, 0, strpos($input, "\n\n"))));
$updates = array_map(function ($item) { return explode(',', $item); }, explode("\n", substr($input, strpos($input, "\n\n"))));

$sum1 = 0;
$sum2 = 0;

foreach ($updates as $update) {
    $step = 1;

    do {
        $updated = false;
        foreach ($pairs as $pair) {
            if (($page1 = array_search($pair[0], $update)) === false) { continue; }
            if (($page2 = array_search($pair[1], $update)) === false) { continue; }
            if ($page1 < $page2) { continue; }

            $step = 2;
            $update[$page1] = $pair[1];
            $update[$page2] = $pair[0];
            $updated = true;

            break;
        }
    } while ($updated === true);

    ${"sum$step"} += (int) $update[(int) (count($update) / 2)];
}

echo "step 1: $sum1\n";
echo "step 2: $sum2\n";
