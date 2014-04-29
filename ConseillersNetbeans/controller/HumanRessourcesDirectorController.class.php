<?php

class HumanRessourcesDirectorController extends BaseController {

	public function __construct($registry) {
		$this->secure = true;
		parent::__construct($registry);
	}

	public function index() {
		$this->registry->template->page_first_title = "Gestion des enseignants chercheurs";

		$hrd = new HumanRessourcesDirectorModel();
		$data = $hrd->getDatas();

		$this->registry->loadComponent('Table');
		$table = $this->registry->TableComponent;
		$table->setDataHeader(array('Nombre d\'étudiants conseillés', 'Prenom', 'Nom', 'Bureau', 'Pole'));
		$table->setDataRow($data);

		$table_view = $this->registry->TableComponent->createView('table_default');
		$this->registry->template->content = $table_view;

		$this->registry->template->show();
	}

}
