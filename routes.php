<?php declare(strict_types=1);

use App\Controllers\CharacterController;
use App\Controllers\EpisodeController;
use App\Controllers\LocationController;

return [
    ['GET', '/', [CharacterController::class, 'index']],
    ['GET', '/random', [CharacterController::class, 'random']],
    ['GET', '/filter', [CharacterController::class, 'filter']],
    ['GET', '/characters', [CharacterController::class, 'characters']],
    ['GET', '/character', [CharacterController::class, 'single']],
    ['GET', '/episodes', [EpisodeController::class, 'all']],
    ['GET', '/episode', [EpisodeController::class, 'single']],
    ['GET', '/locations', [LocationController::class, 'all']],
    ['GET', '/location', [LocationController::class, 'single']]

];