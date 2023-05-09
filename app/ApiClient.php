<?php declare(strict_types=1);

namespace App;

use App\Models\Character;
use App\Models\Episode;
use App\Models\Location;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class ApiClient
{
    private Client $client;
    private const BASE_API = 'https://rickandmortyapi.com/api';

    public function __construct()
    {
        $this->client = new Client(['verify' => false]);
    }

    public function fetchRandomCharacters(): array
    {
        try {
            if (!Cache::has('randomCharacters')) {
                $response = $this->client->get(self::BASE_API . '/character', [
                    'query' => [
                        'page' => floor(rand(1, 42))
                    ]
                ]);
                $responseJson = $response->getBody()->getContents();
                Cache::remember('randomCharacters', $responseJson, 10);
            } else {
                $responseJson = Cache::get('randomCharacters');
            }

            $characterContent = json_decode($responseJson);
            return $this->createCharacterCollection($characterContent->results);

        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchCharactersByName(string $character): array
    {
        try {
            if (!Cache::has('charactersByName')) {
                $response = $this->client->get(self::BASE_API . '/character', [
                    'query' => [
                        'name' => $character
                    ]
                ]);
                $responseJson = $response->getBody()->getContents();
                Cache::remember('charactersByName', $responseJson);
            } else {
                $responseJson = Cache::get('charactersByName');
            }

            $characterContent = json_decode($responseJson);
            return $this->createCharacterCollection($characterContent->results);

        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchCharactersById(array $ids): array
    {
        try {
            if (!Cache::has('characters')) {
                $response = $this->client->get(self::BASE_API . '/character/' . implode(',', $ids));
                $responseJson = $response->getBody()->getContents();
                Cache::remember('characters', $responseJson, 5);
            } else {
                $responseJson = Cache::get('characters');
            }

            $characterContent = (array)json_decode($responseJson);
            return $this->createCharacterCollection($characterContent);

        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchSingleCharacterById(string $id): ?Character
    {
        try {
            if (!Cache::has('character_' . $id)) {
                $response = $this->client->get(self::BASE_API . '/character/' . $id);
                $responseJson = $response->getBody()->getContents();
                Cache::remember('character_' . $id, $responseJson);
            } else {
                $responseJson = Cache::get('character_' . $id);
            }

            $characterContent = json_decode($responseJson);
            return $this->createCharacter($characterContent);

        } catch (GuzzleException $exception) {
            return null;
        }
    }

    public function fetchLocationsById(array $ids): array
    {
        try {
            if (!Cache::has('locations')) {
                $response = $this->client->get(self::BASE_API . '/location/' . implode(',', $ids));
                $responseJson = $response->getBody()->getContents();
                Cache::remember('locations', $responseJson);
            } else {
                $responseJson = Cache::get('locations');
            }

            $locationContent = (array)json_decode($responseJson);
            return $this->createLocationCollection($locationContent);

        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchSingleLocationById(int $id): ?Location
    {
        try {
            if (!Cache::has('location_' . $id)) {
                $response = $this->client->get(self::BASE_API . '/location/' . $id);
                $responseJson = $response->getBody()->getContents();
                Cache::remember('location_' . $id, $responseJson, 5);
            } else {
                $responseJson = Cache::get('location_' . $id);
            }

            $locationContent = json_decode($responseJson);
            return $this->createLocation($locationContent);

        } catch (GuzzleException $exception) {
            return null;
        }
    }

    public function fetchEpisodesById(array $ids): array
    {
        try {
            if (!Cache::has('episodes')) {
                $response = $this->client->get(self::BASE_API . '/episode/' . implode(',', $ids));
                $responseJson = $response->getBody()->getContents();
                Cache::remember('episodes', $responseJson);
            } else {
                $responseJson = Cache::get('episodes');
            }

            $episodesContent = (array)json_decode($responseJson);
            return $this->createEpisodesCollection($episodesContent);

        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchSingleEpisodeById(int $id): ?Episode
    {
        try {
            if (!Cache::has('episode_' . $id)) {
                $response = $this->client->get(self::BASE_API . '/episode/' . $id);
                $responseJson = $response->getBody()->getContents();
                Cache::remember('episode_' . $id, $responseJson);
            } else {
                $responseJson = Cache::get('episode_' . $id);
            }

            $episodeContent = json_decode($responseJson);
            return $this->createEpisode($episodeContent);

        } catch (GuzzleException $exception) {
            return null;
        }
    }

    private function createCharacterCollection(array $characterContent): array
    {
        $collection = [];
        foreach ($characterContent as $character) {
            $collection[] = $this->createCharacter($character);
        }
        return $collection;
    }

    private function createLocationCollection(array $locationContent): array
    {
        $collection = [];
        foreach ($locationContent as $location) {
            $collection[] = $this->createLocation($location);
        }
        return $collection;
    }

    private function createEpisodesCollection(array $episodesContent): array
    {
        $collection = [];
        foreach ($episodesContent as $episode) {
            $collection[] = $this->createEpisode($episode);
        }
        return $collection;
    }

    private function createCharacter(stdClass $characterContent): Character
    {
        $episodeIds = [];
        foreach ($characterContent->episode as $episode) {
            $episodeIds[] = substr($episode, 40);
        }

        $locationId = (int)substr($characterContent->location->url, 41);

        return new Character(
            $characterContent->id,
            $characterContent->name,
            $characterContent->status,
            $characterContent->species,
            $this->fetchSingleLocationById($locationId),
            $characterContent->image,
            $episodeIds,
            $this->fetchSingleEpisodeById((int)$episodeIds[0])
        );
    }

    private function createLocation(stdClass $locationContent): Location
    {
        $residentIds = [];
        foreach ($locationContent->residents as $resident) {
            $residentIds[] = substr($resident, 42);
        }

        return new Location(
            $locationContent->id,
            $locationContent->name,
            $residentIds
        );
    }

    private function createEpisode(stdClass $episodeContent): Episode
    {
        $characterIds = [];
        foreach ($episodeContent->characters as $character) {
            $characterIds[] = substr($character, 42);
        }

        return new Episode(
            $episodeContent->id,
            $episodeContent->name,
            $episodeContent->air_date,
            $episodeContent->episode,
            $characterIds
        );
    }
}