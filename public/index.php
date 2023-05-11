<?php declare(strict_types=1);

use App\Core\Renderer;
use App\Core\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$routes = require_once '../routes.php';

//$client = new \App\ApiClient();
//$characters = $client->filterCharacters('rick', 'alive', 'human', 'male');

//$controller = new \App\Controllers\CharacterController();
//$characters = $controller->filter();
//echo "<pre>";
//var_dump($characters);
//foreach ($characters as $character) {
//    var_dump($character);
//}
//die;

$response = Router::response($routes);
$renderer = new Renderer();

echo $renderer->render($response);