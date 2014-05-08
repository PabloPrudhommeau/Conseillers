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

	public function buildAssignNewStudentTable($data) {

		foreach ($data as $val) {
			if ($val->ec_nom == "") {
				$button = $this->registry->newComponent('ButtonWidget');
				$json_ajax_data = json_encode(array('name' => $val->etu_nom, 'first_name' => $val->etu_prenom));
				$button->setImage('plus.gif');
				$button->setAction('ajax_send(\'' . __SITE_ROOT . '/EducationService/AssignNewStudentAjax/\',\'' . $json_ajax_data . '\',\'.ajax-return\');');
				$val->ec_nom = $button->createView();
			}
			if (preg_match('/TC/', $val->formation)) {
				$button_migration = $this->registry->newComponent('ButtonWidget');
				$json_ajax_data = json_encode(array('name' => $val->etu_nom, 'first_name' => $val->etu_prenom));
				$button_migration->setImage('migration.png');
				$button_migration->setSize(16, 16);
				$button_migration->setAction('ajax_send(\'' . __SITE_ROOT . '/EducationService/AssignNewStudentAjax/\',\'' . $json_ajax_data . '\',\'.ajax-return\');');
				$val->formation = $val->formation . $button_migration->createView();
			}
		}

		$table = $this->registry->newComponent('Table');
		$table->setDataHeader(array('Prenom', 'Nom', 'Formation', 'Conseillé assigné'));
		$table->setDataRow($data);
		$table_view = $table->createView('table_default');

		$ajax_content = $this->registry->newComponent('DivWidget');
		$ajax_content->setClass('ajax-return');
		$ajax_content->setContent($table_view);

		return $ajax_content->createView();
	}

	public function assignNewStudent() {
		$this->registry->template->page_first_title = 'Gestion des élèves';
		$education_service = $this->registry->newModel('EducationService');
		$data = $education_service->getData();
		$this->registry->template->content = $this->buildAssignNewStudentTable($data);
		$this->registry->template->show();
	}

	public function assignNewStudents() {
		$view = 'Voulez vous assigner tous les étudiants orphelins à un conseiller automatiquement ?<br/>';
		$button = $this->registry->newComponent('ButtonWidget');
		$button->setAction('ajax_send(\'' . __SITE_ROOT . '/EducationService/AssignNewStudentsAjax/\',\'\',\'.ajax-return\');');
		$button->setLabel('Oui, je souhaite assigner tous les étudiants');
		$view .= $button->createView('widget_button_classic');

		$ajax_content = $this->registry->newComponent('DivWidget');
		$ajax_content->setClass('ajax-return');

		$view .= $ajax_content->createView();

		$this->registry->template->content = $view;
		$this->registry->template->show();
	}

	/* Méthodes appellées via ajax */
	/*	 * **************************** */

	public function assignNewStudentAjax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$ajax = $this->registry->newComponent('Ajax');
			$data = $ajax->interceptData();
			if (isset($data['name']) && isset($data['first_name'])) {
				$education_service = $this->registry->newModel('EducationService');
				$education_service->assignNewStudent($data['name'], $data['first_name']);
				$education_service = $this->registry->newModel('EducationService');
				$data = $education_service->getData();
				echo $this->buildAssignNewStudentTable($data);
			}
		}
	}

	public function assignNewStudentsAjax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$education_service = $this->registry->newModel('EducationService');
			$data = $education_service->assignNewStudents();
			$content .= '<br/>';
			foreach ($data as $val) {
				$content .= '* Ajout du conseiller <b>' . $val['academic_researcher_surname'] . ' ' . $val['academic_researcher_name'] . '</b> pour l\'étudiant ' . $val['student_surname'] . ' ' . $val['student_name'] . '<br/>';
			}
			echo $content;
		}
	}

	public function studentMigrationAjax() {
		$view = 'Voulez vous assigner tous les étudiants orphelins à un conseiller automatiquement ?';
		$button = $this->registry->newComponent('ButtonWidget');
		$button->setAction('ajax_send(\'' . __SITE_ROOT . '/EducationService/AssignNewStudentsAjax/\',\'\',\'.ajax-return\');');
		$button->setLabel('Oui, je souhaite assigner tous les étudiants');
		$view .= $button->createView('widget_button_classic');

		$ajax_content = $this->registry->newComponent('DivWidget');
		$ajax_content->setClass('ajax-return');

		$view .= $ajax_content->createView();

		$this->registry->template->content = $view;
		$this->registry->template->show();
	}

	/*	 * **************************** */
}
