<?php

class ResearchProfessorListController extends BaseController {

	public function __construct($registry) {
		$this->secure = true;
		parent::__construct($registry);
	}

	public function index() {
		$this->registry->template->page_first_title = "Gestion des enseignants chercheurs";
		$this->registry->template->show();
	}

}
