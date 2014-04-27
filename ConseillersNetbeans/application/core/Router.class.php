<?php

class Router {

	private $registry;
	private $controllerPath;
	private $controllerName;
	private $action;

	function __construct($registry) {
		$this->registry = $registry;
	}

	public function route() {
		$this->getController();
		if (!is_readable($this->controllerPath) || !is_callable(array($this->read($this->controllerName), $this->action))) {
			$this->call('ErrorController', 'e404');
		} else {
			$this->applyRouteWithSecurity();
		}
	}

	private function read($controllerName) {
		require_once __SITE_PATH . '/controller/' . $controllerName . '.class.php';
		$controller = new $controllerName($this->registry);
		return $controller;
	}

	private function call($controllerName, $actionName) {
		require_once __SITE_PATH . '/controller/' . $controllerName . '.class.php';
		require_once 'FrontController.class.php';
		$frontController = new FrontController();
		$frontController->load($this->registry);
		$controller = new $controllerName($this->registry);
		$controller->$actionName();
	}

	private function applyRouteWithSecurity() {
		$this->registry->loadComponent('Authentification');
		$authentification_component = $this->registry->AuthentificationComponent;
		$controllerObject = $this->read($this->controllerName);

		if ($controllerObject->isSecure() && !$authentification_component->isLogOn()) {
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
