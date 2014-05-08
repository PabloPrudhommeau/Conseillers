<?php

class SelectComponent extends BaseComponent {

	private $select_name;
	private $select_class;
	private $select_option = array();

	public function setName($name) {
		$this->select_name = $name;
	}

	public function setClass($class) {
		$this->select_class = $class;
	}

	public function setOption($arr = array()) {
		$this->select_option = $arr;
	}

	public function createView($template = 'select_default') {
		$this->option = $this->select_option;
		$this->name = $this->select_name;
		$this->class = $this->select_class;

		return parent::createView($template);
	}

}

?>