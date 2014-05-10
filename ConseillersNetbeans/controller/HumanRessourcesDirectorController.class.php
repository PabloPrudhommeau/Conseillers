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
		$button->setImage('add.png');
		$button->setAction('showHideElement(\'#table-hidden-row\')');
		$button->setLabel('Ajouter enseignant');
		$content .= $button->createView('widget_button_advanced');

		$data = $humanRessourcesDirector->getData();
		$this->registry->template->content = $content . $this->buildAcademicResearcherTable($data);
		$this->registry->template->show();
	}

	public function buildAcademicResearcherTable($data) {
		$this->registry->template->page_first_title = 'Gestion des enseignants chercheurs';

		$json_ajax_add_data = json_encode(array('surname' => '\'+$(\'#academic-rechearcher-surname\').val()+\'',
			'name' => '\'+$(\'#academic-rechearcher-name\').val()+\''
		));

		$humanRessourcesDirector = $this->registry->newModel('HumanRessourcesDirector');
		$data = $humanRessourcesDirector->getData();
		$button_delete = $this->registry->newComponent('ButtonWidget');
		$button_delete->setImage('croix.png');
		$button_delete->setClass('delete-button');

		foreach ($data as &$val) {
			$json_ajax_delete_data = json_encode(array('name' => $val->nom, 'surname' => $val->prenom));
			$button_delete->setAction('ajax_send(\'' . __SITE_ROOT . '/HumanRessourcesDirector/DeleteAcademicResearcherAjax/\',\'' .
					$json_ajax_delete_data . '\',\'.table-manage-data\');');
			$val->del_button = $button_delete->createView();
		}

		$ajax_content = $this->registry->newComponent('DivWidget');
		$ajax_content->setClass('ajax-return');

		$ajax_function = htmlspecialchars('ajax_send(\'' . __SITE_ROOT . '/HumanRessourcesDirector/ControlAvailability/\',\'' . $json_ajax_add_data . '\',\'.ajax-return\');');

		$input_name = $this->registry->newComponent('Input');
		$input_name->setId('academic-rechearcher-name');
		$input_name->setEvent('onblur="' . $ajax_function . '"');

		$input_surname = $this->registry->newComponent('Input');
		$input_surname->setId('academic-rechearcher-surname');
		$input_surname->setEvent('onblur="' . $ajax_function . '"');

		$input_office = $this->registry->newComponent('Input');
		$input_office->setId('office-researcher');

		$select_area = $this->registry->newComponent('Select');
		$select_area->setOption($humanRessourcesDirector->getArea());
		$select_area->setId('area-researcher');

		$button_add = $this->registry->newComponent('ButtonWidget');
		$button_add->setImage('plus_grey.gif');

		$button_cancel = $this->registry->newComponent('ButtonWidget');
		$button_cancel->setImage('croix.png');
		$button_cancel->setAction('showHideElement(\'#table-hidden-row\')');

		$ajax_content->setContent($button_add->createView());

		$table = $this->registry->newComponent('Table');
		$table->setDataHeader(array('Prenom', 'Nom', 'Bureau', 'Pole'));
		$table->setDataRow($data);
		$table->setHiddenRow(array($input_surname->createView(),
			$input_name->createView(),
			$input_office->createView(),
			$select_area->createView(),
			$ajax_content->createView(),
			$button_cancel->createView()
		));
		$table->setRowClass('deletable-row');

		$content .= $table->createView('table_manage_data');

		return $content;
	}

	/* Méthodes appellées via ajax */
	/*	 * **************************** */

	public function controlAvailability() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$ajax = $this->registry->newComponent('Ajax');
			$data = $ajax->interceptData();
			if (isset($data['name']) && isset($data['surname'])) {
				if ($data['name'] != '' && $data['surname'] != '') {
					$json_ajax_data = json_encode(array('surname' => '\'+$(\'#academic-rechearcher-surname\').val()+\'',
						'name' => '\'+$(\'#academic-rechearcher-name\').val()+\'',
						'office' => '\'+$(\'#office-researcher\').val()+\'',
						'area' => '\'+$(\'#area-researcher\').val()+\''
					));
					$humanRessourcesDirector = $this->registry->newModel('HumanRessourcesDirector');

					$ajax_content = $this->registry->newComponent('DivWidget');
					$ajax_content->setClass('ajax-return');
					if (!$humanRessourcesDirector->alreadyExists($data['name'], $data['surname'])) {
						$button_add = $this->registry->newComponent('ButtonWidget');
						$button_add->setImage('plus.gif');
						$button_add->setAction('ajax_send(\'' . __SITE_ROOT . '/HumanRessourcesDirector/addAcademicResearcherAjax/\',\'' . $json_ajax_data . '\',\'.table-manage-data\');');

						$ajax_content->setContent($button_add->createView());

						echo $ajax_content->createView();
					} else {
						$button_add = $this->registry->newComponent('ButtonWidget');
						$button_add->setImage('plus_grey.gif');

						$ajax_content->setContent($button_add->createView());

						echo $ajax_content->createView();
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

	public function deleteAcademicResearcherAjax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$ajax = $this->registry->newComponent('Ajax');
			$data = $ajax->interceptData();
			if (isset($data['name']) && isset($data['surname'])) {
				$humanRessourcesDirector = $this->registry->newModel('HumanRessourcesDirector');
				$humanRessourcesDirector->deleteAcademicResearcher($data['name'], $data['surname']);

				$data = $humanRessourcesDirector->getData();
				echo $this->buildAcademicResearcherTable($data);
			}
		}
	}

}
