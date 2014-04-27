<?php

class GlobalFeaturesWidgetComponent extends BaseComponent {

	public $feature_link = array();
	
	public function addlink($link) {
		$this->feature_link[] = $link;
	}

	public function createView($template = 'widget_global_feature') {
		$this->links = $this->feature_link;
		return parent::createView($template);
	}

}
