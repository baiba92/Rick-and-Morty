<?php declare(strict_types=1);

namespace App\Controllers;

use App\ApiClient;
use App\Core\View;

class CharacterController
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function search(): View
    {
        $query = $_GET['character'];

        if (!empty($query)) {
            $characters = $this->client->fetchCharactersByName($query);
        } else {
            $characters = $this->client->fetchRandomCharacters();
        }

        return new View('characters', [
            'characters' => $characters
        ]);
    }

    public function single(): View
    {
        $character = $this->client->fetchSingleCharacterById($_GET['characterId']);

        if (count($character->episodeIds()) > 1) {
            $episodes = $this->client->fetchEpisodesById($character->episodeIds());
        } else {
            $episodes[] = $this->client->fetchSingleEpisodeById((int)$character->episodeIds()[0]);
        }

        return new View('singleCharacter', [
            'character' => $character,
            'episodes' => $episodes
        ]);
    }
}