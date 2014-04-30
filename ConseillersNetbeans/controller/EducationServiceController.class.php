<?php

class EducationServiceController extends BaseController {

	public function __construct($registry) {
		$this->secure = true;
		parent::__construct($registry);
	}

	public function index() {
		$this->registry->template->content = 'TODO : liste des fonctionnalités';
		$this->registry->template->show();
	}

	public function assignNewStudent() {
		$this->registry->template->page_first_title = 'Gestion des élèves';

		$education_service = $this->registry->newModel('EducationService');
		$education_service->assignNewStudents();

		$data = $education_service->getData();
		foreach ($data as $val) {
			if ($val->ec_nom == "") {
				$button = $this->registry->newComponent('ButtonWidget');
				$json_ajax_data = json_encode(array('name' => $val->etu_nom, 'first_name' => $val->etu_prenom));
				$button->setImage('plus.gif');
				$button->setAction('ajax_send(\'' . __SITE_ROOT . '/EducationService/AssignNewStudentAjax/\',\'' . $json_ajax_data . '\');');
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

	//Méthode appellée via ajax
	public function assignNewStudentAjax() {
		$ajax = $button = $this->registry->newComponent('Ajax');
		$data = $ajax->interceptData();
		if (isset($data['name']) && isset($data['first_name'])) {
			$education_service = $this->registry->newModel('EducationService');
			$data = $education_service->assigneNewStudent($data['name'], $data['first_name']);
			echo $data;
		}
	}

}
