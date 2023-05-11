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

    public function index(): View
    {
        $characters = $this->client->fetchRandomCharacters();

        return new View('index', [
            'characters' => $characters
        ]);
    }

    public function random(): View
    {
        $characters = $this->client->fetchRandomCharacters();

        return new View('randomCharacters', [
            'characters' => $characters
        ]);
    }

    public function characters(): View
    {
        return new View('characters', []);
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

    public function filter(): View
    {
        $name = $_GET['name'];
        $status = $_GET['status'];
        $species = $_GET['species'];
        $gender = $_GET['gender'];

        $characters = $this->client->filterCharacters($name, $status, $species, $gender);

        $allCharacters = [];
        if ($characters['pages'] > 1) {
            $allCharacters[] = $characters['content'];
            for ($i = 2; $i <= $characters['pages']; $i++) {
                $allCharacters[] = $this->client->filterCharacters($name, $status, $species, $gender, $i)['content'];
            }
            $characters = array_merge(...$allCharacters);
        } else {
            $characters = $characters['content'];
        }

        return new View('filterCharacters', [
            'characters' => $characters
        ]);
    }
}