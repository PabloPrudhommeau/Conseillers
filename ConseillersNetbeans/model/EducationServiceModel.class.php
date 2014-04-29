<?php

class EducationServiceModel {

	public function getDatas() {
		$db = Database::getInstance();
		$query = $db->query('	SELECT 	etu.prenom AS etu_prenom, 
										etu.nom AS etu_nom, 
										CONCAT(p.libelle, etu.semestre) AS formation, 
										ec.prenom AS ec_prenom, 
										ec.nom AS ec_nom, 
										ec.bureau, 
										lp.libelle AS ec_pole
								FROM etudiant AS etu
								LEFT JOIN conseiller AS c ON 			(c.id_etudiant=etu.id)
								LEFT JOIN enseignant_chercheur AS ec ON (ec.id=c.id_enseignant_chercheur)
								LEFT JOIN liste_pole AS lp ON 			(lp.id=ec.id_pole)
								LEFT JOIN liste_programme AS p ON 		(p.id=etu.id_programme)'
							);
		$row = $query->fetchAll();
		return $row;
	}
}

?>