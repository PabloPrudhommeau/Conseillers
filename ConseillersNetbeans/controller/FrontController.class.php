<?php

class FrontController {

	private $registry;

	public function load($registry) {
		$this->registry = $registry;
		
		$menu_main = $this->registry->newComponent('MenuWidget');
		$menu_feature = $this->registry->newComponent('MenuWidget');

		//Menu principal
		$menu_main->addLink(array('value' => 'accueil', 'href' => '/'));
		if ($this->registry->Authentification->isLogOn()) {
			$menu_main->addLink(array('value' => 'déconnexion', 'href' => '/home/signout', 'class' => 'signout'));
		} else {
			$menu_main->addLink(array('value' => 'identification', 'href' => '/home/signin'));
		}
		$this->registry->template->widget_menu_main = $menu_main->createView('widget_menu_main');

		//Menu fonctionnalités
		if ($this->registry->Authentification->isLogOn()) {
			switch ($this->registry->Authentification->getStatut()) {
				case 'drh' :
					$menu_feature->addLink(array('value' => 'Gestion des enseignants chercheurs', 'href' => '/humanRessourcesDirector/'));
					break;
				case 'resp' :
					$menu_feature->addLink(array('value' => 'Gestion des habilitations à conseiller', 'href' => '/programManager'));
					break;
				case 'scol' :
					$menu_feature->addLink(array('value' => 'Gestion des élèves', 'href' => '/educationService'));
					break;
			}
			$this->registry->template->widget_menu_feature = $menu_feature->createView('widget_menu_feature');
		}
	}
}
