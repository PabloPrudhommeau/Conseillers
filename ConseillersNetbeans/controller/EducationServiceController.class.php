<?php

class EducationServiceController extends BaseController {

	public function __construct($registry) {
		$this->secure = true;
		parent::__construct($registry);
	}

	public function index() {
		$this->registry->template->page_first_title = 'Gestion des élèves';

		$education_service = $this->registry->newModel('EducationService');
		$data = $education_service->getData();
		foreach ($data as $key => $val) {
			if ($val->ec_nom == "") {
				$button = $this->registry->newComponent('ButtonWidget');
				$button->setImage('plus.gif');
				$button->setAction('assign_new_student(\''.$val->etu_nom.'\', \''.$val->etu_prenom.'\');');
				$val->ec_nom = $button->createView();
			}
		}

		$table = $this->registry->newComponent('Table');
		$table->setDataHeader(array('Prenom', 'Nom', 'Formation', 'Conseillé habilité'));
		$table->setDataRow($data);

		$table_view = $table->createView('table_default');

		$this->registry->template->content = $table_view;
		$this->registry->template->show();
	}

	public function assignNewStudent() {
		$ajax = $button = $this->registry->newComponent('Ajax');
		$data = $ajax->interceptData();
		if(isset($data['name']) && isset($data['first_name'])){
			$education_service = $this->registry->newModel('EducationService');
			$data = $education_service->assigneNewStudent($data['name'], $data['first_name']);
			echo $data;
		}
	}

}
