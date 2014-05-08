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

	public function manageResearcher() {
		$this->registry->template->page_first_title = 'Gestion des enseignants chercheurs';

		$json_ajax_data = json_encode(array('name' => $val->etu_nom, 'surname' => $val->etu_prenom));

		$humanRessourcesDirector = $this->registry->newModel('HumanRessourcesDirector');
		$data = $humanRessourcesDirector->getData();

		$button = $this->registry->newComponent('ButtonWidget');
		$button->setImage('plus.gif');
		$button->setAction('showHideElement(\'#table-hidden-row\')');
		$button->setLabel('Ajouter enseignant');
		$content = $button->createView('widget_button_advanced');

		$content .= '<br/>';

		$input_name = $this->registry->newComponent('Input');
		$input_name->setClass('table-manage-data');
		$input_name->setId('academic-rechearcher-name');
		$input_surname = $this->registry->newComponent('Input');
		$input_surname->setClass('table-manage-data');
		$input_surname->setId('academic-rechearcher-surname');
		$input_office = $this->registry->newComponent('Input');
		$input_office->setClass('table-manage-data');
		$select_area = $this->registry->newComponent('Select');
		$select_area->setOption($humanRessourcesDirector->getArea());

		$input_name = $this->registry->newComponent('Input');
		$input_name->setClass('table-manage-data');
		$input_name->setId('academic-rechearcher-name');
		$input_name->setOnblur('ajax_send(\'' . __SITE_ROOT . '/HumanRessourcesDirector/ControlAvailability/\',\'\',\'#table-hidden-row\');');

		$input_surname = $this->registry->newComponent('Input');
		$input_surname->setClass('table-manage-data');
		$input_surname->setId('academic-rechearcher-surname');
		$input_surname->setOnblur('ajax_send(\'' . __SITE_ROOT . '/HumanRessourcesDirector/ControlAvailability/\',\'\',\'#table-hidden-row\');');

		$input_office = $this->registry->newComponent('Input');
		$input_office->setClass('table-manage-data');

		$select_area = $this->registry->newComponent('Select');
		$select_area->setOption($humanRessourcesDirector->getArea());

		$table = $this->registry->newComponent('Table');
		$table->setDataHeader(array('Prenom', 'Nom', 'Bureau', 'Pole'));
		$table->setDataRow($data);
		$table->setHiddenRow(array(	$input_name->createView(), 
									$input_surname->createView(), 
									$input_office->createView(), 
									$select_area->createView()
							));

		$ajax_content = $this->registry->newComponent('DivWidget');
		$ajax_content->setClass('ajax-return');
		$ajax_content->setContent($table->createView('table_manage_data'));

		$content .= $ajax_content->createView();

		$this->registry->template->content = $content;
		$this->registry->template->show();
	}

	/* Méthodes appellées via ajax */
	/*	 * **************************** */

	public function assignNewStudentAjax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$ajax = $button = $this->registry->newComponent('Ajax');
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

	public function controlAvailability() {
		if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$ajax = $this->registry->newComponent('Ajax');
			$data = $ajax->interceptData();
			$humanRessourcesDirector = $this->registry->newModel('HumanRessourcesDirector');
			$data = $humanRessourcesDirector->getData();
			echo $this->manageResearcher;
			if(isset($data['name']) && isset($data['surname'])) {
				if($data['name'] != '' && $data['surname'] != '') {
					$input_name = $this->registry->newComponent('Input');
					$input_name->setClass('table-manage-data');
					$input_name->setId('academic-rechearcher-name');
					$input_name->setOnblur('ajax_send(\'' . __SITE_ROOT . '/HumanRessourcesDirector/ControlAvailability/\',\'\',\'#table-hidden-row\');');

					$input_surname = $this->registry->newComponent('Input');
					$input_surname->setClass('table-manage-data');
					$input_surname->setId('academic-rechearcher-surname');
					$input_surname->setOnblur('ajax_send(\'' . __SITE_ROOT . '/HumanRessourcesDirector/ControlAvailability/\',\'\',\'#table-hidden-row\');');

					$input_office = $this->registry->newComponent('Input');
					$input_office->setClass('table-manage-data');

					$select_area = $this->registry->newComponent('Select');
					$select_area->setOption($humanRessourcesDirector->getArea());

					$table = $this->registry->newComponent('Table');
					$table->setDataHeader(array('Prenom', 'Nom', 'Bureau', 'Pole', $button->createView()));
					$table->setDataRow($data);
					$table->setHiddenRow(array(	$input_name->createView(), 
												$input_surname->createView(), 
												$input_office->createView(), 
												$select_area->createView()
										));

					$table_view = $table->createView('table_manage_data');
					$this->registry->template->content = $table_view;

					$this->registry->template->show();
				}
			}
		}
	}

}
