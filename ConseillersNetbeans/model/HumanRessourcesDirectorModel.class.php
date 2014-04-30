<?php

class HumanRessourcesDirectorModel {

	public function getData() {
		$db = Database::getInstance();
		$query = $db->query('	SELECT COUNT( c.id_enseignant_chercheur ) AS nbetu, ec.prenom, ec.nom, ec.bureau, lp.libelle
								FROM conseiller AS c
								LEFT JOIN enseignant_chercheur AS ec ON ( ec.id = c.id_enseignant_chercheur )
								LEFT JOIN liste_pole AS lp ON ( lp.id = ec.id_pole )
								GROUP BY c.id_enseignant_chercheur'
							);
		$row = $query->fetchAll();
		return $row;
	}
}

?>