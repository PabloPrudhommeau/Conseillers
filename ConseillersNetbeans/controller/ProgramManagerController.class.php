<?php

class ProgramManagerController extends BaseController {

	public function __construct($registry) {
		$this->secure = true;
		parent::__construct($registry);
	}

	public function index() {
		$this->registry->template->page_first_title = "Gestion des habilitations à conseiller";

		$program_manager = new ProgramManagerModel();
		$data = $program_manager->getDatas();

		$this->registry->loadComponent('Table');
		$table = $this->registry->TableComponent;
		$table->setDataHeader(array(array('Prenom', 1, 'Nom', 1, 'Bureau', 1, 'Habilitations', 6)));
		$table->setDataRow($data);

		$table_view = $this->registry->TableComponent->createView('table_default');
		$this->registry->template->content = $table_view;

		$this->registry->template->show();
	}

}
