<?php

class FrontController {

	private $registry;

	public function load($registry) {
		$this->registry = $registry;
		$this->registry->loadComponent('MenuWidget');

		//Menu principal
		$menu = $this->registry->MenuWidgetComponent;
		$menu->addLink(array('value' => 'accueil', 'href' => '/'));
		if ($this->registry->AuthentificationComponent->isLogOn()) {
			$menu->addLink(array('value' => 'déconnexion', 'href' => '/home/signout', 'class' => 'signout'));
		} else {
			$menu->addLink(array('value' => 'identification', 'href' => '/home/signin'));
		}
		$this->registry->template->widget_menu_main = $menu->createView('widget_menu_main');

		//Menu fonctionnalités
		$features = $this->registry->MenuWidgetComponent;
		if ($this->registry->AuthentificationComponent->isLogOn()) {
			switch ($this->registry->AuthentificationComponent->getStatut()) {
				case 'drh' :
					$features->addLink(array('value' => 'Gestion des enseignants chercheurs', 'href' => '/ResearchProfessorList'));
					break;
				case 'resp' :
					$features->addLink(array('value' => 'Gestion des enseignants chercheurs', 'href' => '/Habilitation'));
					break;
				case 'scol' :
					$features->addLink(array('value' => 'Gestion de la liste des étudiants', 'href' => '/StudentList'));
					$features->addLink(array('value' => 'Gestion des conseillers', 'href' => '/AdvisorsManagement'));
					break;
			}
			$this->registry->template->widget_menu_feature = $features->createView('widget_menu_feature');
		}
	}
}
