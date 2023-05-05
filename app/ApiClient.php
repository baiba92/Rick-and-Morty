<?php declare(strict_types=1);

namespace App;

use App\Models\Character;
use App\Models\Episode;
use GuzzleHttp\Client;

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
        $response = $this->client->get(self::BASE_API . '/character', [
            'query' => [
                'page' => floor(rand(1, 42))
            ]
        ]);
        $characterContent = json_decode($response->getBody()->getContents());
        return $this->createCharacterCollection($characterContent->results);
    }

    public function fetchCharactersByName(string $character): array
    {
        $response = $this->client->get(self::BASE_API . '/character', [
            'query' => [
                'name' => $character
            ]
        ]);
        $characterContent = json_decode($response->getBody()->getContents());
        return $this->createCharacterCollection($characterContent->results);
    }

    public function fetchMultipleCharactersById(string $ids): array
    {
        $response = $this->client->get(self::BASE_API . '/character/' . $ids);
        $characterContent = json_decode($response->getBody()->getContents());
        return $this->createCharacterCollection($characterContent);
    }

    public function fetchCharacterById(string $id): Character
    {
        $response = $this->client->get(self::BASE_API . '/character/' . $id);
        $characterContent = json_decode($response->getBody()->getContents());

        $ids = [];
        foreach ($characterContent->episode as $episode) {
            $ids[] = substr($episode, 40);
        }
        return new Character(
            $characterContent->id,
            $characterContent->name,
            $characterContent->status,
            $characterContent->species,
            $characterContent->location->name,
            $characterContent->image,
            $this->fetchEpisodeById($ids)
        );
    }

    public function fetchSingleEpisode(int $id): Episode
    {
        $response = $this->client->get(self::BASE_API . '/episode/' . $id);
        $episodeContent = json_decode($response->getBody()->getContents());

        $ids = [];
        foreach ($episodeContent->characters as $character) {
            $ids[] = substr($character, 42);
        }
        $characters = $this->fetchMultipleCharactersById(implode(',', $ids));
        return new Episode(
            $episodeContent->id,
            $episodeContent->name,
            $episodeContent->air_date,
            $episodeContent->episode,
            $characters
        );
    }

    public function fetchEpisodes(): array
    {
        $episodesContent = [];
        for ($i = 1; $i <= 51; $i++) {
            $response = $this->client->get(self::BASE_API . '/episode/' . $i);
            $episodesContent[] = json_decode($response->getBody()->getContents());
        }
        return $this->createEpisodeCollection($episodesContent);
    }

    public function fetchEpisodeById(array $id): array
    {
        $response = $this->client->get(self::BASE_API . '/episode/' . implode(',', $id));
        return (array)json_decode($response->getBody()->getContents());
    }

    private function createCharacterCollection(array $characterContent): array
    {
        $collection = [];
        foreach ($characterContent as $character) {
            $collection[] = new Character(
                $character->id,
                $character->name,
                $character->status,
                $character->species,
                $character->location->name,
                $character->image,
                (array)$this->fetchEpisodeById((array)substr($character->episode[0], 40))
            );
        }
        return $collection;
    }

    private function createEpisodeCollection(array $episodesContent): array
    {
        $collection = [];
        foreach ($episodesContent as $episode) {
            $collection[] = new Episode(
                $episode->id,
                $episode->name,
                $episode->air_date,
                $episode->episode,
                $episode->characters
            );
        }
        return $collection;
    }
}