<?php
declare(strict_types=1);

namespace App\Service;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\JsonResponse;

class Task2Service
{
    private Client $client;
    private string $api = 'https://swapi.dev/api/';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->api,
            'verify' => false,
        ]);
    }

    private function getJson(string $url): array
    {
        $response = $this->client->get($url);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function findPlanetByName(string $planetName): ?array
    {
        $data = $this->getJson('planets/?search=' . urlencode($planetName));
        foreach ($data['results'] ?? [] as $planet) {
            if (strcasecmp($planet['name'], $planetName) === 0) {
                return $planet;
            }
        }
        return null;
    }

    public function getResidentsUrlFromPlanet(string $planetName): array
    {
        $planet = $this->findPlanetByName($planetName);
        return $planet['residents'] ?? [];
    }

    public function findStarshipsWithPilotsFromPlanetRaw(string $planetName): array
    {
        $residentsFromPlanet = $this->getResidentsUrlFromPlanet($planetName);

        $result = [];
        $url = 'starships/';
        do {
            $data = $this->getJson($url);

            foreach ($data['results'] as $starship) {
                foreach ($starship['pilots'] as $pilotUrl) {
                    if (in_array($pilotUrl, $residentsFromPlanet, true)) {
                        $result[] = $starship;
                        break;
                    }
                }
            }

            $url = $data['next'] ?? null;
            if ($url) {
                $url = str_replace($this->api, '', $url);
            }

        } while ($url);

        return [
            'planet' => $planetName,
            'starships_with_pilot_from_planet' => $result,
        ];
    }

    public function findStarshipsWithPilotsFromPlanet(string $planetName): JsonResponse
    {
        $data = $this->findStarshipsWithPilotsFromPlanetRaw($planetName);
        return new JsonResponse($data);
    }

    public function findStarshipsWithPilotsFromPlanetPrettyJson(string $planetName): string
    {
        $data = $this->findStarshipsWithPilotsFromPlanetRaw($planetName);
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
