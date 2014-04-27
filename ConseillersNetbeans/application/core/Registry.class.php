<?php

class Registry {

	private $vars = array();

	public function loadComponent($name) {
		$name = ucwords($name).'Component';
		$file = __SITE_PATH . '/application/component/' . $name . '.class.php';
		if (is_readable($file) == false) {
			throw new Exception('Le composant ' . $name . ' n\'existe pas');
		} else {
			require($file);
			$this->$name = new $name;
		}
	}

	public function __set($index, $value) {
		$this->vars[$index] = $value;
	}

	public function __get($index) {
		return $this->vars[$index];
	}

}

?>
