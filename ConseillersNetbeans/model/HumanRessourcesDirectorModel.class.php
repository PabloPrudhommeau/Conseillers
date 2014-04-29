<?php

class HumanRessourcesDirectorModel {

	public function getDatas() {
		$db = Database::getInstance();
		$query = $db->query('	SELECT COUNT( c.id_enseignant_chercheur ) AS nbetu, ec.nom, ec.prenom, ec.bureau, lp.libelle
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