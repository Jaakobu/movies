<?php
Class Router {

	private $_routes = [];
	private $_basePath = '';
	private $_pathNotFound = '';

	public function __contruct() {
		
	}


	/**
	 * Create route
	 */
	public function map($method, $route, $target, $name = null) {
		$this->_routes[] = [$method, $route, $target, $name];
	}


	/**	
	 * Update basepath
	 */
	public function setBasePath(string $basePath) {
		$this->_basePath = $basePath;
	}
	
	
	/**	
	 * Update _pathNotFound
	 */
	public function setPathNotFound(string $_pathNotFound) {
		$this->_pathNotFound = $_pathNotFound;
	}


	/**
	 * 404 redirect
	 */
	private function _notFound() {
		header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
		if (!$this->_pathNotFound) :
			echo '404';
			die;
		endif;
		require_once $this->_pathNotFound;
	}


	/**	
	 * 
	 */
	public function match() {
		// Get current url request
		$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
		$url = substr($url, strlen($this->_basePath));

		// Get method
		$currentMethod = $_SERVER['REQUEST_METHOD'];

		// Check exist current route
		foreach ($this->_routes as $route) :
			// Check current method equal
			if ($currentMethod !== strtoupper($route[0])) :
				continue;
			endif;

			// Exist route
			if ($route[1] === $url) :
				return [
					'target' => $route[2],
					'name' => $route[3]
					//'params' => $route[3]
				];
			endif;
		endforeach;

		$this->_notFound();
	}


	public function generate(string $name) {

	}
}

require_once 'src/config/config.php';
$customRouter = new Router();
$customRouter->setBasePath('greta/2020/structure-2/');
//$customRouter->setPathNotFound(PAGES . 'errors/404.php');

$customRouter->map('GET', '/admin', 'users/admin_index.php', 'usersList');
$customRouter->map('GET', '/hello', 'users/admin_index.php', 'usersList2');

$match = $customRouter->match();
/*

if ($match) :
	// Prepare load controllers
	$controller = explode('.php', $match['target']);
	$controller = $controller[0] . 'Controller.php';

	// Params routes
	if (!empty($match['params'])) :
		$_GET = array_merge($_GET, $match['params']);
	endif;
	
	require_once CONTROLLERS . $controller; // Load controllers
	if (strpos($match['target'], 'api/') === false) :
		require_once PAGES . $match['target']; // Load views
	endif;
else :
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
	require_once PAGES . 'errors/404.php';
endif;
*/
dump($match);
die();

