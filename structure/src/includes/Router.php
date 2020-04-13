<?php
class Router {

	private $_basePath = '';
	private $_pathNotFound = '';
	private $_routes = [];
	private $_nameRoutes = [];


	/**	
	 * Create a route
	 * 
	 * @param string $method
	 * @param string $route
	 * @param string $target
	 * @param string $name
	 */
	public function map(string $method, string $route, string $target, string $name = '') {
		$this->_routes[] = [
			'method' => $method, 
			'route' => $route, 
			'target' => $target, 
			'name' => $name
		];
		$this->_existNameRoute($name, $route);
	}


	/**
	 * Check already exist current name route into $_nameRoutes
	 * 
	 * @param string $name
	 * @param string $route
	 */
	private function _existNameRoute(string $name, string $route) {
		if ($name) :
			if (array_key_exists($name, $this->_nameRoutes)) :
				throw new RuntimeException('This route name already exists.');
			endif;
			$this->_nameRoutes[$name] = $route;
		endif;
	}


	public function match() {
		$url = str_replace($this->_basePath, '', $_SERVER['REQUEST_URI']);
		$method = $_SERVER['REQUEST_METHOD'];

		foreach ($this->_routes as $route) :
			// Check method with current method
			if ($method !== strtoupper($route['method'])) :
				continue;
			endif;
			
			if ($route['route'] === $url) :
				return [
					'target' => $route['target'],
					'name' => $route['name']
				];
			endif;
		endforeach;

		$this->_notFound();
	}


	private function _notFound() {
		header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
		if ($this->_pathNotFound) :
			require_once $this->_pathNotFound;
		else :
			die('Use setPathNotFound() to define path.');
		endif;
	}


	public function setBasePath(string $name) {
		$this->_basePath = $name;
	}
	
	
	public function setPathNotFound(string $path) {
		$this->_pathNotFound = $path;
	}


	public function generate() {
		
	}
}

$router = new Router;
$router->setBasePath('/greta/2020/structure-2');
$router->setPathNotFound('admin/404.php');
$router->map('GET', '/cgv2', 'cgv.php', 'goToCgv2');
$router->map('GET', '/login', 'users/login.php', 'login');
$router->map('delete', '/cgv', 'cgv.php', 'goToCgv');
$router->match();
die;
