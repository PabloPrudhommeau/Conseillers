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

	public function manageAcademicResearcher() {
		$this->registry->template->page_first_title = 'Gestion des enseignants chercheurs';
		$humanRessourcesDirector = $this->registry->newModel('HumanRessourcesDirector');

		$button = $this->registry->newComponent('ButtonWidget');
		$button->setImage('plus.gif');
		$button->setAction('showHideElement(\'#table-hidden-row\')');
		$button->setLabel('Ajouter enseignant');
		$content = $button->createView('widget_button_advanced');

		$data = $humanRessourcesDirector->getData();
		$this->registry->template->content = $content . $this->buildAcademicResearcherTable($data);
		$this->registry->template->show();
	}

	public function buildAcademicResearcherTable($data) {
		$this->registry->template->page_first_title = 'Gestion des enseignants chercheurs';

		$json_ajax_data = json_encode(	array('surname' => '\'+$(\'#academic-rechearcher-surname\').val()+\'', 
											'name' => '\'+$(\'#academic-rechearcher-name\').val()+\'',
											'office' => '\'+$(\'#office-researcher\').val()+\'',
											'area' => '\'+$(\'#area-researcher\').val()+\''
										));

		$humanRessourcesDirector = $this->registry->newModel('HumanRessourcesDirector');
		$data = $humanRessourcesDirector->getData();

		$content .= '<br/>';

		$input_name = $this->registry->newComponent('Input');
		$input_name->setClass('table-manage-data valide');
		$input_name->setId('academic-rechearcher-name');
		$input_name->setBlur('ajax_send(\'' . __SITE_ROOT . '/HumanRessourcesDirector/ControlAvailability/\',\'' . $json_ajax_data . '\',\'#table-hidden-row\');');

		$input_surname = $this->registry->newComponent('Input');
		$input_surname->setClass('table-manage-data valide');
		$input_surname->setId('academic-rechearcher-surname');
		$input_surname->setBlur('ajax_send(\'' . __SITE_ROOT . '/HumanRessourcesDirector/ControlAvailability/\',\'' . $json_ajax_data . '\',\'#table-hidden-row\');');

		$input_office = $this->registry->newComponent('Input');
		$input_office->setClass('table-manage-data');
		$input_office->setId('office-researcher');

		$select_area = $this->registry->newComponent('Select');
		$select_area->setOption($humanRessourcesDirector->getArea());
		$select_area->setId('area-researcher');

		$table = $this->registry->newComponent('Table');
		$table->setDataHeader(array('Prenom', 'Nom', 'Bureau', 'Pole'));
		$table->setDataRow($data);
		$table->setHiddenRow(array(	$input_surname->createView(), 
									$input_name->createView(), 
									$input_office->createView(), 
									$select_area->createView()
							));

		$ajax_content = $this->registry->newComponent('DivWidget');
		$ajax_content->setClass('ajax-return');
		$ajax_content->setContent($table->createView('table_manage_data'));

		$content .= $ajax_content->createView();

		return $content;
	}

	/* Méthodes appellées via ajax */
	/*	 * **************************** */

	public function controlAvailability() {
		if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$ajax = $this->registry->newComponent('Ajax');
			$data = $ajax->interceptData();
			if(isset($data['name']) && isset($data['surname']) && isset($data['office']) && isset($data['area'])) {
				if($data['name'] != '' && $data['surname'] != '') {
					$json_ajax_data = json_encode(	array('surname' => '\'+$(\'#academic-rechearcher-surname\').val()+\'', 
											'name' => '\'+$(\'#academic-rechearcher-name\').val()+\'',
											'office' => '\'+$(\'#office-researcher\').val()+\'',
											'area' => '\'+$(\'#area-researcher\').val()+\''
										));

					$humanRessourcesDirector = $this->registry->newModel('HumanRessourcesDirector');
					$input_name = $this->registry->newComponent('Input');
					$input_name->setId('academic-rechearcher-name');
					$input_name->setBlur('ajax_send(\'' . __SITE_ROOT . '/HumanRessourcesDirector/ControlAvailability/\',\'' . $json_ajax_data . '\',\'#table-hidden-row\');');
					$input_name->setValue($data['name']);

					$input_surname = $this->registry->newComponent('Input');
					$input_surname->setId('academic-rechearcher-surname');
					$input_surname->setBlur('ajax_send(\'' . __SITE_ROOT . '/HumanRessourcesDirector/ControlAvailability/\',\'' . $json_ajax_data . '\',\'#table-hidden-row\');');
					$input_surname->setValue($data['surname']);

					$input_office = $this->registry->newComponent('Input');
					$input_office->setClass('table-manage-data');
					$input_office->setId('office-researcher');
					$input_office->setValue($data['office']);

					$select_area = $this->registry->newComponent('Select');
					$select_area->setOption($humanRessourcesDirector->getArea());
					$select_area->setId('area-researcher');
					$select_area->setValue($data['area']);

					if($humanRessourcesDirector->alreadyExists($data['name'], $data['surname'])) {
						$input_surname->setClass('table-manage-data invalide');
						$input_name->setClass('table-manage-data invalide');

						echo '<td>';
						echo $input_surname->createView();
						echo '</td>';
						echo '<td>';
						echo $input_name->createView();
						echo '</td>';
						echo '<td>';
						echo $input_office->createView();
						echo '</td>';
						echo '<td>';
						echo $select_area->createView();
						echo '</td>';

					} else {
						$input_surname->setClass('table-manage-data valide');
						$input_name->setClass('table-manage-data valide');

						$button = $this->registry->newComponent('ButtonWidget');
						$button->setImage('plus.gif');
						$button->setAction('ajax_send(\'' . __SITE_ROOT . '/HumanRessourcesDirector/AddAcademicResearcherAjax/\',\'' . $json_ajax_data . '\',\'.ajax-return\');');

						echo '<td>';
						echo $input_surname->createView();
						echo '</td>';
						echo '<td>';
						echo $input_name->createView();
						echo '</td>';
						echo '<td>';
						echo $input_office->createView();
						echo '</td>';
						echo '<td>';
						echo $select_area->createView();
						echo '</td>';
						echo '<td>';
						echo $button->createView();
						echo '</td>';
					}		
				}
			}
		}
	}

	public function addAcademicResearcherAjax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$ajax = $this->registry->newComponent('Ajax');
			$data = $ajax->interceptData();
			if (isset($data['name']) && isset($data['surname']) && isset($data['office']) && isset($data['area'])) {
				$humanRessourcesDirector = $this->registry->newModel('HumanRessourcesDirector');
				$humanRessourcesDirector->addAcademicResearcher($data['name'], $data['surname'], $data['office'], $data['area']);
				$data = $humanRessourcesDirector->getData();
				echo $this->buildAcademicResearcherTable($data);
			}
		}
	}

}
