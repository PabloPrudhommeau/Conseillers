<?php

class Router {

	private $registry;
	private $controllerPath;
	private $controllerName;
	private $action;

	function __construct($registry) {
		$this->registry = $registry;
		$this->registry->loadComponent('Authentification');
	}

	public function route() {
		$this->getController();
		if (!is_readable($this->controllerPath) || !is_callable(array($this->read($this->controllerName), $this->action))) {
			$this->call('ErrorController', 'e404');
		} else {
			$this->applyRouteWithSecurity();
		}
	}

	private function read($controller_name) {
		require_once __SITE_PATH . '/controller/' . $controller_name . '.class.php';
		$controller = new $controller_name($this->registry);
		return $controller;
	}

	private function call($controller_name, $action_name) {
		require_once __SITE_PATH . '/controller/' . $controller_name . '.class.php';
		require_once 'FrontController.class.php';
		$front_controller = new FrontController();
		$front_controller->load($this->registry);
		$controller = new $controller_name($this->registry);
		$controller->$action_name();
	}

	private function applyRouteWithSecurity() {
		$authentification_component = $this->registry->AuthentificationComponent;
		$controller_object = $this->read($this->controllerName);

		if ($controller_object->isSecure() && !$authentification_component->isLogOn()) {
			$this->call('ErrorController', 'restricted');
		} else {
			$this->call($this->controllerName, $this->action);
		}
	}

	private function getController() {

		$route = (empty($_GET['route'])) ? '' : $_GET['route'];

		if (!empty($route)) {
			$parts = explode('/', $route);
			$controller = ucfirst($parts[0]);
			if (isset($parts[1])) {
				$this->action = $parts[1];
			}
		}

		if (empty($controller)) {
			$controller = 'index';
		}

		if (empty($this->action)) {
			$this->action = 'index';
		}

		$this->controllerName = ucwords($controller) . 'Controller';
		$this->controllerPath = 'controller/' . ucwords($controller) . 'Controller.class.php';
	}

}

?>
