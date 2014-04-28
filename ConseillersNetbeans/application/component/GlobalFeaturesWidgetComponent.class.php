<?php

class GlobalFeaturesWidgetComponent extends BaseComponent {

	public $feature_link = array();
	
	public function addlink($name,$link) {
		$this->feature_link[$name] = $link;
	}

	public function createView($template = 'widget_global_feature') {
		$this->links = $this->feature_link;
		return parent::createView($template);
	}

}
