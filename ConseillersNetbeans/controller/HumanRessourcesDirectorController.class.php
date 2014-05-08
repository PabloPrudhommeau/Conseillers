<?php

class HumanRessourcesDirectorController extends BaseController {

	public function __construct($registry) {
		$this->secure = true;
		parent::__construct($registry);
	}

	public function index() {
		$this->registry->template->content = 'TODO : liste des fonctionnalités';
		$this->registry->template->show();
	}
	
	public function manageResearcher(){
		$this->registry->template->page_first_title = 'Gestion des enseignants chercheurs';

		$humanRessourcesDirector = $this->registry->newModel('HumanRessourcesDirector');
		$data = $humanRessourcesDirector->getData();

		$button = $this->registry->newComponent('ButtonWidget');
		$button->setImage('plus.gif');
		$button->setOnClick('showHideRow(\'table-hidden-row\')');

		$table = $this->registry->newComponent('Table');
		$table->setDataHeader(array('Prenom', 'Nom', 'Bureau', 'Pole', $button->createView()));
		$table->setDataRow($data);
		$table->setHiddenRow(array('Prenom', 'Nom', 'Bureau', $humanRessourcesDirector->getPole()));

		$table_view = $table->createView('table_manage_data');
		$this->registry->template->content = $table_view;

		$this->registry->template->show();
	}

}
