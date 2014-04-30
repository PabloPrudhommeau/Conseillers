<?php

class ProgramManagerController extends BaseController {

	public function __construct($registry) {
		$this->secure = true;
		parent::__construct($registry);
	}

	public function index() {
		$this->registry->template->content = 'TODO : liste des fonctionnalités';
		$this->registry->template->show();
	}
	
	public function manageHabilitation(){
		
		$this->registry->template->page_first_title = "Gestion des habilitations des conseillers";

		$program_manager = $this->registry->newModel('ProgramManager');
		$data = $program_manager->getData();

		$table = $this->registry->newComponent('Table');
		$table->setCaption('Titre du tableau');
		$table->setDataHeader(array('Prenom','Nom','Bureau', 'Habilitations'));
		$table->setDataRow($data);

		$table_view = $table->createView('table_default');
		$this->registry->template->content = $table_view;

		$this->registry->template->show();
	}

}
