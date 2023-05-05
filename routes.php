<?php declare(strict_types=1);

return [
    ['GET', '/', ['App\Controllers\CharacterController', 'search']],
    ['GET', '/search', ['App\Controllers\CharacterController', 'search']],
    ['GET', '/episodes', ['App\Controllers\EpisodeController', 'all']],
    ['GET', '/episode', ['App\Controllers\EpisodeController', 'single']],
    ['GET', '/character', ['App\Controllers\CharacterController', 'single']]
];