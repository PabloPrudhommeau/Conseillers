<?php

class Authentification extends BaseComponent {

	public function __construct($registry) {
		session_start();
	}

	public function getStatut(){
		return $_SESSION['statut'];
	}
	
	public function signin($user, $password, $statut) {
		$_SESSION['user'] = $user;
		$_SESSION['password'] = $password;
		$_SESSION['statut'] = $statut;
	}
	
	public function signout(){
		unset($_SESSION['user']);
		unset($_SESSION['password']);
		unset($_SESSION['statut']);
	}

	public function goHome() {
		switch ($_SESSION['statut']) {
			case 'drh' :
				header('Location: ' . __SITE_ROOT . __HOME_HUMAN_RESSOURCES_DIRECTOR);
				break;
			case 'resp' :
				header('Location: ' . __SITE_ROOT . __HOME_PROGRAM_MANAGER);
				break;
			case 'scol' :
				header('Location: ' . __SITE_ROOT . __HOME_EDUCATION_SERVICE);
				break;
		}
	}

	public function isLogOn() {
		if (isset($_SESSION['user']) && isset($_SESSION['password']) && isset($_SESSION['statut'])) {
			return true;
		}
		return false;
	}
}
