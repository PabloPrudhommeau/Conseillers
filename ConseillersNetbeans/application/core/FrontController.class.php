<?php

class FrontController {

	private $registry;

	public function load($registry) {
		$this->registry = $registry;
		if ($this->registry->AuthentificationComponent->isLogOn()) {
			$this->registry->loadComponent('GlobalFeaturesWidget');
			$this->registry->GlobalFeaturesWidgetComponent->addLink('ok');
			$global_features = $this->registry->GlobalFeaturesWidgetComponent->createView();
			$this->registry->template->widget_global_feature = $global_features;
		}
	}

}
