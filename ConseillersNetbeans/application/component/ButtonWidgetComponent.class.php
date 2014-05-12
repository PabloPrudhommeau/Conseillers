<?php

class ButtonWidgetComponent extends BaseComponent {

	public function setAction($action) {
		$this->action = urlencode($action);
	}

	public function setLabel($label) {
		$this->label = $label;
	}

	public function setClass($class) {
		$this->class = $class;
	}

	public function createView($template = 'widget_button_default') {
		return parent::createView($template);
	}

}
