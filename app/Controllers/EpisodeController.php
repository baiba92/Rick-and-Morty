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
        $episodes = $this->client->fetchEpisodes();
        return new View('episodes', [
            'episodes' => $episodes
        ]);
    }

    public function single(): View
    {
        $episode = $this->client->fetchSingleEpisode((int)$_GET['episodeId']);
        return new View('singleEpisode', [
            'episode' => $episode
        ]);
    }
}