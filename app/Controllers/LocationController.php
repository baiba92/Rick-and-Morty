<?php  declare(strict_types=1);

namespace App\Controllers;

use App\ApiClient;
use App\Core\View;

class LocationController
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function all(): View
    {
        $locations = $this->client->fetchAllLocations();
        return new View('locations', [
            'locations' => $locations
        ]);
    }

    public function single(): View
    {
        $location = $this->client->fetchSingleLocationById((int)$_GET['locationId']);

        if (count($location->residentIds()) > 1) {
            $characters = $this->client->fetchCharactersById($location->residentIds());
        } elseif (count($location->residentIds()) == 0) {
            $characters = [];
        } else {
            $characters[] = $this->client->fetchSingleCharacterById($location->residentIds()[0]);
        }

        return new View('singleLocation', [
            'location' => $location,
            'characters' => $characters
        ]);
    }
}
