<?php

class AuthentificationComponent extends BaseComponent {

	public function __construct() {
		session_start();
	}

	public function signin($user, $password, $statut) {
		$_SESSION['user'] = $user;
		$_SESSION['password'] = $password;
		$_SESSION['statut'] = $statut;
	}

	public function goHome() {

		switch ($_SESSION['statut']) {
			case 'drh' :
				header('Location: ' . __SITE_ROOT . __HOME_DRH);
				break;
			case 'responsable_programme' :
				header('Location: ' . __SITE_ROOT . __HOME_RESPONSABLE_PROGRAMME);
				break;
			case 'service_scolarite' :
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
