<?php

class EducationServiceController extends BaseController {

	public function __construct($registry) {
		$this->secure = true;
		parent::__construct($registry);
	}

	public function index() {
		$this->registry->template->page_first_title = "Gestion des élèves";

		$edu_service = new EducationServiceModel();
		$data = $edu_service->getDatas();

		$this->registry->loadComponent('Table');
		$table = $this->registry->TableComponent;
		$table->setDataHeader(array(array('Etudiants', 3, 'Enseignants chercheurs', 3),
									array('Prenom', 1, 'Nom', 1, 'Formation', 1, 'Prenom', 1, 'Nom', 1, 'Bureau', 1, 'Pole', 1)));
		$table->setDataRow($data);

		$table_view = $this->registry->TableComponent->createView('table_default');
		$this->registry->template->content = $table_view;

		$this->registry->template->show();
	}

}
