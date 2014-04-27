<?php

class IndexController extends BaseController {

	public function index() {
		$this->registry->template->content = 'Projet LO07, attribution des conseillers';
		$this->registry->template->show();
	}

}

?>