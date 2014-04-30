<?php

class EducationServiceModel {

	public function getData() {
		$db = Database::getInstance();
		$query = $db->query('	SELECT 	etu.prenom AS etu_prenom, 
										etu.nom AS etu_nom, 
										CONCAT(p.libelle, etu.semestre) AS formation, 
										ec.nom AS ec_nom
								FROM etudiant AS etu
								LEFT JOIN conseiller AS c ON 			(c.id_etudiant=etu.id)
								LEFT JOIN enseignant_chercheur AS ec ON (ec.id=c.id_enseignant_chercheur)
								LEFT JOIN liste_pole AS lp ON 			(lp.id=ec.id_pole)
								LEFT JOIN liste_programme AS p ON 		(p.id=etu.id_programme)'
		);
		$row = $query->fetchAll();
		return $row;
	}

	public function assigneNewStudent($name, $firstname) {
		$db = Database::getInstance();
		$query = $db->query('	SELECT ec.nom AS ec_nom
								FROM etudiant AS etu
								LEFT JOIN habilitation AS hb ON			(etu.id_programme = hb.id_programme)
								LEFT JOIN enseignant_chercheur AS ec ON (ec.id = hb.id_enseignant_chercheur)
								LEFT JOIN conseiller AS c ON 			(c.id_enseignant_chercheur=ec.id)
								WHERE hb.id_programme = etu.id_programme
								AND etu.nom = "'.$name.'"
								AND etu.prenom = "'.$firstname.'"'
		);
		$row = $query->fetchAll();
		return 'Conseiller à ajouter : '.$row[0]->ec_nom.' (TODO : prendre le conseiller qui a le plus petit nombre d\'habilitation, puis l\'insérer physiquement en base)';
	}

}

?>