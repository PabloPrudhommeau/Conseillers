<?php

class ProgramManagerController extends BaseController {

	public function __construct($registry) {
		$this->secure = true;
		parent::__construct($registry);
	}

	public function index() {
		$this->registry->template->content = 'TODO : liste des fonctionnalités';
		$this->registry->template->show();
	}

	public function manageHabilitation() {

		$this->registry->template->page_first_title = "Gestion des habilitations des conseillers";

		$program_manager = $this->registry->newModel('ProgramManager');
		$data = $program_manager->getData();

		$table = $this->registry->newComponent('Table');
		$programme = $this->registry->Authentification->getSession('programme');
		$table->setDataHeader(array('Prenom', 'Nom', 'Bureau', 'Habilité ' . $programme));
		foreach ($data as $key => $val) {
			$button = $this->registry->newComponent('ButtonWidget');
			if (in_array($programme, $val->libelle)) {
				$button->setClass('check');
			} else {
				$json_ajax_data = json_encode(array('name' => $val->nom, 'surname' => $val->prenom));
				$button->setClass('none');
				$button->setAction('ajax_send(\'' . __SITE_ROOT . '/ProgramManager/AddAuthorizarionAjax/\',\'' . $json_ajax_data . '\',\'.ajax-return-' . $key . '\');');
			}
			$ajaxContent = $this->registry->newComponent('DivWidget');
			$ajaxContent->setClass('ax ajax-return-' . $key);
			$ajaxContent->setContent($button->createView());
			$data[$key]->libelle = $ajaxContent->createView();
		}
		$table->setDataRow($data);
		$table_view = $table->createView('table_default');

		$this->registry->template->content = $table_view;

		$this->registry->template->show();
	}

	/* Méthodes appellées via ajax */
	/*	 * **************************** */

	public function addAuthorizarionAjax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$ajax = $this->registry->newComponent('Ajax');
			$data = $ajax->interceptData();
			if (isset($data['name']) && isset($data['surname'])) {
				$program_manager = $this->registry->newModel('ProgramManager');
				$program_manager->addAuthorization($data['name'], $data['surname'], $this->registry->Authentification->getSession('programme'));
				$button = $this->registry->newComponent('ButtonWidget');
				$button->setClass('check');
				echo $button->createView();
			}
		}
	}

}
