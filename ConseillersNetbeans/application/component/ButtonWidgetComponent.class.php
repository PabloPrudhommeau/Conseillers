<?php

class ButtonWidgetComponent extends BaseComponent {

	public function setImage($image) {
		$this->image = __SITE_ROOT . '/assets/img/' . $image;
	}

	public function setAction($action) {
		$this->action = urlencode($action);
	}

	public function setLabel($label) {
		$this->label = $label;
	}

	public function setSize($width, $height) {
		$this->width = $width;
		$this->height = $height;
	}

	public function setOnClick($action) {
		$this->onClick = $action;
	}

	public function createView($template = 'widget_button_default') {
		return parent::createView($template);
	}

}
