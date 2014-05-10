<?php

class HumanRessourcesDirectorModel {

	public function getData() {
		$db = Database::getInstance();
		$query = $db->query('	SELECT ec.prenom, ec.nom, ec.bureau, lp.libelle
								FROM enseignant_chercheur AS ec
								LEFT JOIN liste_pole AS lp ON ( lp.id = ec.id_pole )'
				);
		$row = $query->fetchAll();

		return $row;
	}

	public function getDataDesc() {
		$db = Database::getInstance();
		$query = $db->query('	SELECT SUM(CASE WHEN c.id_etudiant IS NULL THEN 0 ELSE 1 END) AS nbetu, ec.prenom, ec.nom, ec.bureau, lp.libelle
								FROM conseiller AS c
								RIGHT OUTER JOIN enseignant_chercheur AS ec ON ( ec.id = c.id_enseignant_chercheur )
								LEFT JOIN liste_pole AS lp ON ( lp.id = ec.id_pole )
								GROUP BY (ec.id)
								ORDER BY nbetu DESC'
				);
		$row = $query->fetchAll();

		return $row;
	}

	public function getCounsellor() {
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

	public function getCounsellorWithStudent() {
		$db = Database::getInstance();

		$query = $db->query(' 	SELECT 	ec.prenom AS ec_prenom, 
										ec.nom AS ec_nom, 
										etu.prenom AS etu_prenom, 
										etu.nom AS etu_nom, 
										CONCAT(lp.libelle, etu.semestre) AS formation 
								FROM enseignant_chercheur AS ec
								LEFT JOIN conseiller AS c ON ( c.id_enseignant_chercheur=ec.id )
								LEFT JOIN etudiant AS etu ON ( etu.id=c.id_etudiant )
								LEFT JOIN liste_programme AS lp ON ( lp.id=etu.id_programme )
								WHERE etu.prenom IS NOT NULL'
				);
		$counsellor_student = $query->fetchAll();
		$structured_data = array();

		foreach ($counsellor_student as $key => $value) {
			$structured_data_key =  $value->ec_prenom.'&nbsp;'.$value->ec_nom;
			unset($value->ec_prenom);
			unset($value->ec_nom);
			$structured_data[$structured_data_key][] = $value;
		}

		return $structured_data;
	}

	public function alreadyExists($name, $surname) {
		$db = Database::getInstance();
		$query = $db->query('	SELECT id FROM enseignant_chercheur
								WHERE nom="' . $name . '"
								AND prenom="' . $surname . '"'
		);
		$row = $query->fetch();
		if ($row) {
			return true;
		} else {
			return false;
		}
	}

	public function addAcademicResearcher($name, $surname, $office, $research_group) {
		$db = Database::getInstance();
		$query = $db->query('SELECT id FROM liste_pole WHERE libelle="' . $research_group . '"');
		$id_research_group = $query->fetch();

		$st = $db->prepare('INSERT INTO enseignant_chercheur(nom, prenom, bureau, id_pole) VALUES (																	
																						\'' . $name . '\',
																						\'' . $surname . '\',
																						\'' . $office . '\',
																						\'' . $id_research_group->id . '\')'
				);
		$st->execute();
	}

	public function getArea() {
		$db = Database::getInstance();
		$query = $db->query('SELECT libelle FROM liste_pole');
		$row = $query->fetchAll(PDO::FETCH_COLUMN);

		return $row;
	}

	public function addAcademicResearchers($file) {
		/*
		 * Ajout d'enseignants pas injection CSV
		 * Définir si le fichier est lu ici ou avant
		 */
	}

	public function purgeAcademicResearcher() {
		$db = Database::getInstance();

		$st = $db->prepare('DELETE FROM habilitation');
		$st->execute();

		$st = $db->prepare('DELETE FROM conseiller');
		$st->execute();

		$st = $db->prepare('DELETE FROM enseignant_chercheur');
		$st->execute();
	}

	public function deleteAcademicResearcher($name, $surname) {
		$db = Database::getInstance();
		$query = $db->query('	SELECT id FROM enseignant_chercheur 
								WHERE nom="' . $name . '" 
								AND prenom="' . $surname . '"'
				);
		$id_academic_researcher = $query->fetch();

		$st = $db->prepare('DELETE FROM habilitation WHERE id_enseignant_chercheur=' . $id_academic_researcher->id);
		$st->execute();

		$st = $db->prepare('DELETE FROM conseiller WHERE id_enseignant_chercheur=' . $id_academic_researcher->id);
		$st->execute();

		$st = $db->prepare('DELETE FROM enseignant_chercheur WHERE id=' . $id_academic_researcher->id);
		$st->execute();
	}

}

?>
