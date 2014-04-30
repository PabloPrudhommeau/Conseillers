<?php

class Authentification extends BaseComponent {

	private $registry;

	public function __construct($registry) {
		$this->registry = $registry;
		session_start();
	}

	public function getStatut() {
		return $_SESSION['statut'];
	}

	public function signin($user, $password, $statut) {
		$_SESSION['user'] = $user;
		$_SESSION['password'] = $password;
		$_SESSION['statut'] = $statut;
	}

	public function signout() {
		unset($_SESSION['user']);
		unset($_SESSION['password']);
		unset($_SESSION['statut']);
	}

	public function goHome() {
		$statut = $_SESSION['statut'];
		header('Location:' . __SITE_ROOT . $this->registry->json_data->links->$statut->home);
	}

	public function isLogOn() {
		if (isset($_SESSION['user']) && isset($_SESSION['password']) && isset($_SESSION['statut'])) {
			return true;
		}
		return false;
	}

}
