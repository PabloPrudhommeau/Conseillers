<?php

class AuthentificationComponent extends BaseComponent {

	public function __construct() {
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
				header('Location: ' . __SITE_ROOT . __HOME_DRH);
				break;
			case 'resp' :
				header('Location: ' . __SITE_ROOT . __HOME_RESPONSABLE_PROGRAMME);
				break;
			case 'scol' :
				header('Location: ' . __SITE_ROOT . __HOME_SERVICE_SCOLARITE);
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
