<?php

class Utils
{
    private const string URL = 'https://adventofcode.com/%d/day/%d/input';

    public static function getInput(int $year, int $day): array
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => 'Cookie: session=' . getenv('AOC_SESSION'),
            ]
        ]);

        return file(sprintf(self::URL, $year, $day), false, $context);
    }
}
