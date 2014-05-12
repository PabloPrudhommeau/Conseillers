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

	public function showOrphans() {
		$this->registry->template->page_first_title = 'Présentation des étudiants orphelins';
		$education_service = $this->registry->newModel('EducationService');

		$data = $education_service->getOrphan();

		$table = $this->registry->newComponent('Table');
		$table->setDataHeader(array('Prenom', 'Nom', 'Formation'));
		$table->setDataRow($data);

		$this->registry->template->content = $table->createView();
		$this->registry->template->show();
	}

	public function showStudentByProgram() {
		$this->registry->template->page_first_title = 'Présentation des étudiants par programme';
		$education_service = $this->registry->newModel('EducationService');

		$json_ajax_data = json_encode(array('program' => '\'+$(\'#program-select\').val()+\''));

		$program_select = $this->registry->newComponent('Select');
		$program_select->setOption($education_service->getAllFormation());
		$program_select->setId('program-select');
		$program_select->setEvent('onChange=ajax_send(\'' . __SITE_ROOT . '/EducationService/ShowStudentByProgramAjax/\',\'' . $json_ajax_data . '\',\'.ajax-return\');');

		$this->registry->template->content = $program_select->createView() . $this->buildStudentTable($education_service->getStudentByProgram('TC'));
		$this->registry->template->show();
	}

	public function manageStudent() {
		$this->registry->template->page_first_title = 'Gestion des étudiants et de leur conseillé';
		$education_service = $this->registry->newModel('EducationService');

		$button = $this->registry->newComponent('ButtonWidget');
		$button->setClass('add-button-extend');
		$button->setAction('showHideElement(\'#table-hidden-row\')');
		$button->setLabel('Ajouter étudiant');
		$content .= $button->createView() . '<br/><br/>';

		$data = $education_service->getData();
		$this->registry->template->content = $content . $this->buildManageStudentTable($data);
		$this->registry->template->show();
	}

	public function buildStudentTable($data) {
		$table = $this->registry->newComponent('Table');

		$table->setDataHeader(array('Prenom', 'Nom', 'Formation', 'Conseillé assigné'));
		$table->setDataRow($data);

		$table_view = $table->createView();

		$ajax_content = $this->registry->newComponent('DivWidget');
		$ajax_content->setClass('ajax-return');
		$ajax_content->setContent($table_view);

		return $ajax_content->createView();
	}

	public function buildManageStudentTable($data) {
		$education_service = $this->registry->newModel('EducationService');

		$button_delete = $this->registry->newComponent('ButtonWidget');
		$button_delete->setClass('delete-button');

		foreach ($data as $val) {
			if ($val->ec_nom == "") {
				$button = $this->registry->newComponent('ButtonWidget');
				$json_ajax_data = json_encode(array('name' => $val->etu_nom, 'surname' => $val->etu_prenom));
				$button->setClass('add-active');
				$button->setAction('ajax_send(\'' . __SITE_ROOT . '/EducationService/AssignNewStudentAjax/\',\'' . $json_ajax_data . '\',\'.ajax-return\');');
				$val->ec_nom = $button->createView();
			}

			$json_ajax_delete_data = json_encode(array('id' => $val->id));
			$button_delete->setAction('ajax_send(\'' . __SITE_ROOT . '/EducationService/DeleteStudentAjax/\',\'' . $json_ajax_delete_data . '\',\'.ajax-return\');');
			$val->del_button = $button_delete->createView();
			unset($val->id);
		}

		$input_name = $this->registry->newComponent('Input');
		$input_name->setId('student-name');

		$input_surname = $this->registry->newComponent('Input');
		$input_surname->setId('student-surname');

		$student_formation = $this->registry->newComponent('Select');
		$student_formation->setOption($education_service->getAllFormation());
		$student_formation->setId('student-formation');

		$input_semester = $this->registry->newComponent('Input');
		$input_semester->setId('student-semester');
		$input_semester->setPlaceHolder('Semestre');

		$json_ajax_data = json_encode(array('surname' => '\'+$(\'#student-surname\').val()+\'',
			'name' => '\'+$(\'#student-name\').val()+\'',
			'formation' => '\'+$(\'#student-formation\').val()+\'',
			'semester' => '\'+$(\'#student-semester\').val()+\''
		));

		$button_add = $this->registry->newComponent('ButtonWidget');
		$button_add->setClass('add-inactive');
		$button_add->setAction('ajax_send(\'' . __SITE_ROOT . '/EducationService/AddStudentAjax/\',\'' . $json_ajax_data . '\',\'.ajax-return\');');

		$button_cancel = $this->registry->newComponent('ButtonWidget');
		$button_cancel->setClass('cancel-button');
		$button_cancel->setAction('showHideElement(\'#table-hidden-row\')');

		$table = $this->registry->newComponent('Table');
		$table->setDataHeader(array('Prenom', 'Nom', 'Formation', 'Conseillé assigné'));
		$table->setDataRow($data);
		$table->setHiddenRow(array($input_surname->createView(),
			$input_name->createView(),
			$student_formation->createView() . $input_semester->createView(),
			$button_add->createView(),
			$button_cancel->createView()
		));
		$table->setRowClass('deletable-row');

		$table_view = $table->createView('table_manage_data');

		$ajax_content = $this->registry->newComponent('DivWidget');
		$ajax_content->setClass('ajax-return');
		$ajax_content->setContent($table_view);

		return $ajax_content->createView();
	}

	public function addStudents() {
		$this->registry->template->page_first_title = 'Ajouter une liste d\'étudiants';

		$form = $this->registry->newComponent('Form');
		$form->init('post', '', 'enctype="multipart/form-data"');
		$form->addField('Fichier', 'file', array('type' => 'file', 'maxlength' => '20', 'id' => 'fichier-CSV'))
				->addFieldRule('file', array('rule_type' => 'operator', 'rule_value' => 'file_added', 'rule_bool' => false));

		if ($form->isValid()) {
			$education_service = $this->registry->newModel('EducationService');
			$file = $form->getFile();

			$csv_header = array('numero', 'prenom', 'nom', 'programme', 'semestre');

			if (!file_exists($file['file']['tmp_name']) || !is_readable($file['file']['tmp_name'])) {
				$form->addCommonError('Un problème a été rencontré à la lecture du fichier');
			} else {
				$header = NULL;
				$data = array();
				$error = false;
				if (($handle = fopen($file['file']['tmp_name'], 'r')) !== FALSE) {
					while (($row = fgetcsv($handle, 1000, ';')) !== FALSE) {
						if (!$header) {
							if ($row == $csv_header) {
								$header = $row;
							} else {
								$form->addCommonError('Ce fichier ne correspond pas au format attendu');
								$error = true;
								break;
							}
						} else {
							if (count($header) != count($row)) {
								$form->addCommonError('Une erreur a été rencontré pendant la lectures des données, vérifiez leur formalisme et recommencez');
								$error = true;
							} else {
								$data[] = array_combine($header, $row);
							}
						}
					}
					fclose($handle);
				}

				if (!$error) {
					$affected_data = $education_service->addStudents($data);
					$content .= '<br/>';

					switch (count($affected_data)) {
						case 0:
							$content .= 'Aucun étudiant n\'a été ajouté';
							break;
						case 1:
							$content .= 'Un étudiant a été ajouté :';
							break;
						default:
							$content .= count($affected_data) . ' étudiants ont été ajouté :';
							break;
					}

					$content .= '<br/>';

					foreach ($affected_data as $val) {
						$content .= '* Ajout de l\'étudiant<b> ' . $val['prenom'] . ' ' . $val['nom'] . '</b><br/>';
					}
				}
			}
		}

		$this->registry->template->content = $form->createView() . $content;
		$this->registry->template->show();
	}

	public function purgeStudent() {
		$this->registry->template->page_first_title = 'Effacer tous les étudiants';

		$view = 'Êtes vous sûr de supprimer tous les étudiants de la base de données impliquant le retrait de tous leur conseillé ?<br/>';
		$button = $this->registry->newComponent('ButtonWidget');
		$button->setAction('ajax_send(\'' . __SITE_ROOT . '/EducationService/PurgeStudentAjax/\',\'\',\'.ajax-return\');');
		$button->setLabel('Oui, je souhaite effacer tous les étudiants de la base de données');
		$view .= $button->createView('widget_button_classic');

		$ajax_content = $this->registry->newComponent('DivWidget');
		$ajax_content->setClass('ajax-return');

		$view .= $ajax_content->createView();

		$this->registry->template->content = $view;
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
			if (isset($data['name']) && isset($data['surname'])) {
				$education_service = $this->registry->newModel('EducationService');
				$affected_data = $education_service->assignNewStudent($data['name'], $data['surname']);

				$content = '';

				if ($affected_data == 0) {
					$content = 'Aucun enseignant ne peut conseiller <b>' . $data['surname'] . ' ' . $data['name'] . '</b>';
				}
				$data = $education_service->getData();
				echo $content . $this->buildManageStudentTable($data);
			}
		}
	}

	public function showStudentByProgramAjax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$ajax = $this->registry->newComponent('Ajax');
			$data = $ajax->interceptData();
			if (isset($data['program'])) {
				$education_service = $this->registry->newModel('EducationService');
				$data = $education_service->getStudentByProgram($data['program']);
				echo $this->buildStudentTable($data);
			}
		}
	}

	public function purgeStudentAjax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$education_service = $this->registry->newModel('EducationService');
			$data = $education_service->purgeStudent();
			echo '<br />Tous les étudiants ont été effacés';
		}
	}

	public function DeleteStudentAjax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$ajax = $this->registry->newComponent('Ajax');
			$data = $ajax->interceptData();
			if (isset($data['id'])) {
				$education_service = $this->registry->newModel('EducationService');
				$education_service->deleteStudent($data['id']);
				$data = $education_service->getData();
				echo $this->buildManageStudentTable($data);
			}
		}
	}

	public function addStudentAjax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$ajax = $this->registry->newComponent('Ajax');
			$data = $ajax->interceptData();
			if (isset($data['name']) && isset($data['surname']) && isset($data['formation']) && isset($data['semester'])) {
				$education_service = $this->registry->newModel('EducationService');
				$education_service->addStudent($data['name'], $data['surname'], $data['formation'], $data['semester']);
				$data = $education_service->getData();
				echo $this->buildManageStudentTable($data);
			}
		}
	}

	public function assignNewStudentsAjax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$education_service = $this->registry->newModel('EducationService');
			$data = $education_service->assignNewStudents();
			$content .= '<br/>';
			foreach ($data as $val) {
				if ($val['academic_researcher_name'] == '') {
					$content .= '- Aucun enseignant ne peut conseiller l\'étudiant ' . $val['student_surname'] . ' ' . $val['student_name'] . '<br />';
				} else {
					$content .= '* Ajout du conseiller <b>' . $val['academic_researcher_surname'] . ' ' . $val['academic_researcher_name'] . '</b> pour l\'étudiant ' . $val['student_surname'] . ' ' . $val['student_name'] . '<br/>';
				}
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
