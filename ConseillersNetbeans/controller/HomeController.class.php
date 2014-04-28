<?php

class HomeController extends BaseController {

	public function index() {
		$this->registry->template->show();
	}

	public function signin() {
		$this->registry->template->page_second_title = 'Authentification';
		if ($this->registry->AuthentificationComponent->isLogOn()) {
			$this->registry->AuthentificationComponent->goHome();
		} else {
			$this->registry->loadComponent('Form');
			$form = $this->registry->FormComponent;
			$form->init('post', '');
			$form->addField('Nom d\'utilisateur', 'user', array('type' => 'text', 'maxlength' => '20'))
					->addField('Mot de passe', 'password', array('type' => 'password', 'maxlength' => '20'))
					->addFieldRule('user', array('rule_type' => 'operator', 'rule_value' => 'empty', 'rule_bool' => false))
					->addFieldRule('password', array('rule_type' => 'operator', 'rule_value' => 'empty', 'rule_bool' => false));

			if ($form->isValid()) {
				$auth = MemberArea::getInstance();
				$user = $form->getFieldValue('user');
				$password = $form->getFieldValue('password');
				$token = $auth->getToken($user, $password);
				if ($token) {
					$this->registry->AuthentificationComponent->signin($user, $password, $token['statut']);
					$this->registry->AuthentificationComponent->goHome();
				} else {
					$form->addCommonError('Ce couple utilisateur/mot de passe n\'a pas permis de vous authentifier');
				}
			}

			$form_view = $this->registry->FormComponent->createView('form_default');
			$this->registry->template->content = $form_view;
			$this->registry->template->show();
		}
	}
	
	public function signout(){
		$this->registry->AuthentificationComponent->signout();
		header('Location:'.__SITE_ROOT.'/');
	}

}
?>
