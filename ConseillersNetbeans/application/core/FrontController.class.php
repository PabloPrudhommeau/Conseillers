<?php

class FrontController {

	private $registry;

	public function load($registry) {
		$this->registry = $registry;
		
		$navigation = array();
		$navigation['accueil'] = "";
		
		if ($this->registry->AuthentificationComponent->isLogOn()) {
			
			$navigation['déconnexion'] = "/home/signout";
			
			$this->registry->loadComponent('GlobalFeaturesWidget');

			$statut = $this->registry->AuthentificationComponent->getStatut();
			switch ($statut) {
				case 'drh' :
					$this->registry->GlobalFeaturesWidgetComponent->addLink('Gestion des enseignants chercheurs', '/ResearchProfessorList');
					break;
				case 'resp' :
					$this->registry->GlobalFeaturesWidgetComponent->addLink('Gestion des enseignants chercheurs', '/Habilitation');
					break;
				case 'scol' :
					$this->registry->GlobalFeaturesWidgetComponent->addLink('Gestion de la liste des étudiants', '/StudentList');
					$this->registry->GlobalFeaturesWidgetComponent->addLink('Gestion des conseillers', '/AdvisorsManagement');
					break;
			}

			$this->registry->template->widget_global_feature = $this->registry->GlobalFeaturesWidgetComponent->createView();
		} else {
			$navigation['identification'] = "/home/signin";
		}
		
		$this->registry->template->navigation = $navigation;
	}

}
