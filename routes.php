<?php declare(strict_types=1);

use App\Controllers\CharacterController;
use App\Controllers\EpisodeController;
use App\Controllers\LocationController;

return [
    ['GET', '/', [CharacterController::class, 'search']],
    ['GET', '/search', [CharacterController::class, 'search']],
    ['GET', '/episodes', [EpisodeController::class, 'all']],
    ['GET', '/episode', [EpisodeController::class, 'single']],
    ['GET', '/character', [CharacterController::class, 'single']],
    ['GET', '/locations', [LocationController::class, 'all']],
    ['GET', '/location', [LocationController::class, 'single']]
];