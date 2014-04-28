<?php

class RegisteredModel {

	private static $instance = NULL;

	private function __construct() {
		
	}

	private function __clone() {
		
	}

	public static function getInstance() {
		if (!self::$instance) {
			self::$instance = new RegisteredModel();
		}
		return self::$instance;
	}

	public static function getToken($user, $password) {
		$db = Database::getInstance();
		$query = $db->query('SELECT b.libelle FROM compte as a '
				. 'LEFT JOIN liste_statut as b ON a.id_statut = b.id '
				. 'WHERE login="' . $user . '" AND password=MD5("' . $password . '")');
		$row = $query->fetch();
		if ($row) {
			return array('statut'=>$row->libelle);
		}
		return false;
	}

}

?>