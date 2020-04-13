<?php
// Use session 
session_start();

// Load dependecies composer
require_once 'vendor/autoload.php';
require_once 'src/includes/Router.php';

// Load custom files
require_once 'src/config/config.php';
require_once 'src/config/database.php';
require_once 'src/includes/tools.php';
require_once 'src/includes/uploadFile.php';
require_once 'src/includes/form.php';

// Init router
$router = new AltoRouter();
$router->setBasePath(BASEPATH);

// Create route
require_once 'src/routes/admin.php';
require_once 'src/routes/public.php';
require_once 'src/routes/api.php';

// Execute routes
$match = $router->match();

// Display content
if ($match) :
	// Prepare load controllers
	$controller = explode('.php', $match['target']);
	$controller = $controller[0] . 'Controller.php';

	// Params routes
	/*if (!empty($match['params'])) :
		$_GET = array_merge($_GET, $match['params']);
	endif;*/

	// Check admin
	checkAdmin($router, $match['target']);
	
	require_once CONTROLLERS . $controller; // Load controllers
	if (strpos($match['target'], 'api/') === false) :
		require_once PAGES . $match['target']; // Load views
	endif;
else :
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
	require_once PAGES . 'errors/404.php';
endif;
