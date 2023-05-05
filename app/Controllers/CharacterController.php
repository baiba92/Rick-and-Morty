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
        $character = $this->client->fetchCharacterById($_GET['characterId']);
        $episodes = $character->episodes();
        $firstEpisode = $character->firstEpisode();
        return new View('singleCharacter', [
            'character' => $character,
            'episodes' => $episodes,
            'firstEpisode' => $firstEpisode
        ]);
    }
}