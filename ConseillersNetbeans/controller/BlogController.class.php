<?php

class BlogController extends BaseController {

	public function index() {
		$this->registry->template->show();
	}

	public function authentification() {
		$this->registry->template->page_second_title = 'Authentification';
		if ($this->registry->AuthentificationComponent->isLogOn()) {
			$this->registry->AuthentificationComponent->goHome();
		} else {
			$this->registry->loadComponent('Form');
			$form = $this->registry->FormComponent;
			$form->init('post', '');
			$form->addField('text', 'Nom d\'utilisateur', 'user')
					->addField('password', 'Mot de passe', 'password');
			$form->addFieldRule('user', 'operator', 'empty', false)
					->addFieldRule('password', 'operator', 'empty', false);

			if ($form->isValid()) {
				$auth = MemberArea::getInstance();
				$user = $form->getFieldValue('user');
				$password = $form->getFieldValue('password');
				$token = $auth->getToken($user, $password);
				if ($token) {

					$this->registry->AuthentificationComponent->signin($user, $password, $token['statut']);
					$this->registry->AuthentificationComponent->goHome();
				}
			}

			$form_view = $this->registry->FormComponent->createView();
			$this->registry->template->content = $form_view;
			$this->registry->template->show();
		}
	}

}
?>
