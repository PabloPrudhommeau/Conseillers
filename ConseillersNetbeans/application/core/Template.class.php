<?php

class Template {

	private $registry;
	private $vars = array();
	private $base;

	public function __construct($registry) {
		$this->registry = $registry;
	
		$this->defaults();
		
	}

	public function __set($index, $value) {
		$this->vars[$index] = $value;
	}

	private function defaults() {
		$this->title = __SITE_DEFAULT_TITLE;
		$this->page_first_title = __TEMPLATE_DEFAULT_FIRST_TITLE;
	}

	public function show() {
		if (!in_array('base', $this->vars)) {
			$this->base = __SITE_PATH . '/view/' . __TEMPLATE_DEFAULT_VIEW . '.php';
		} else {
			$this->base = __SITE_PATH . '/view/' . $this->vars['base'] . '.php';
		}

		if (file_exists($this->base) == false) {
			throw new Exception('Le template demandé n\'existe pas : ' . $this->base);
		}

		foreach ($this->vars as $key => $value) {
			$$key = $value . "\n";
		}

		include ($this->base);
	}

}

?>
