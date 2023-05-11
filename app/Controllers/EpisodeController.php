<?php declare(strict_types=1);

namespace App\Controllers;

use App\ApiClient;
use App\Core\View;

class EpisodeController
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function all(): View
    {
        $episodes = $this->client->fetchEpisodesById(range(1, 51));
        return new View('episodes', [
            'episodes' => $episodes
        ]);
    }

    public function single(): View
    {
        $episode = $this->client->fetchSingleEpisodeById((int)$_GET['episodeId']);
        $characters = $this->client->fetchCharactersById($episode->characterIds());

        return new View('singleEpisode', [
            'episode' => $episode,
            'characters' => $characters
        ]);
    }
}