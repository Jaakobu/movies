<?php
/**	
 * Route for api
 */

// Movies
$router->map('GET', '/api/v1/movies', 'api/movies/index.php');
$router->map('POST', '/api/v1/movies', 'api/movies/add.php');