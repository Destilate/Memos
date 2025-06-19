<?php
declare(strict_types=1);

namespace App\Service;

class Task1Service
{
    public function createRandomArray(int $itemCount = 1000000, int $min = 1, int $max = 1000000): array
    {
        $array = [];
        for ($i = 0; $i < $itemCount; $i++) {
            $array[] = rand($min, $max);
        }
        return $array;
    }

    public function checkForDuplicitiesInArray($array): array
    {
        $counts = array_count_values($array);
        return array_filter($counts, fn($count) => $count > 1);
    }
}
