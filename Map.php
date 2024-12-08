<?php

class Map
{
    public static function create(int $width, int $height, string $fill = '.'): array
    {
        $map = [];

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $map[$y][$x] = $fill;
            }
        }

        return $map;
    }

    public static function show($map): void
    {
        foreach ($map as $y => $row) {
            foreach ($row as $x => $c) {
                echo $c;
            }
            echo "\n";
        }
        echo "\n";
    }
}
