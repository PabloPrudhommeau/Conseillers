<?php

class ButtonWidgetComponent extends BaseComponent {
	
	public function setImage($image){
		$this->image = __SITE_ROOT.'/assets/img/'.$image;
	}
	
	public function setAction($action){
		$this->action = urlencode($action);
	}

	public function createView($template = 'widget_button_default') {
		return parent::createView($template);
	}
}
