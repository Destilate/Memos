<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Crew;

class Task3Service
{
    public function getSubordinates(Crew $crew): array
    {
        $result = [];
        $this->collectSubordinates($crew, $result);
        return $result;
    }

    private function collectSubordinates(Crew $crew, array &$result): void
    {
        foreach ($crew->getSubordinates() as $sub) {
            $result[] = $sub->getFullname();
            $this->collectSubordinates($sub, $result);
        }
    }

    public function tracePlaguePath(Crew $start): array
    {
        $path = [];
        $current = $start->getParent();

        while ($current !== null && $current->getParent() !== null) {
            $path[] = $current->getFullname();
            $current = $current->getParent();
        }

        return $path;
    }
}
