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
		$query = $db->query('	SELECT COUNT( c.id_enseignant_chercheur ) AS nbetu, ec.prenom, ec.nom, ec.bureau, lp.libelle
								FROM conseiller AS c
								LEFT JOIN enseignant_chercheur AS ec ON ( ec.id = c.id_enseignant_chercheur )
								LEFT JOIN liste_pole AS lp ON ( lp.id = ec.id_pole )
								GROUP BY c.id_enseignant_chercheur
								ORDER BY nbetu DESC'
							);
		$row = $query->fetchAll();

		return $row;
	}

	public function getConseilor() {
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

	public function alreadyExists($name, $surname) {
		$db = Database::getInstance();
		$query = $db->query('	SELECT id FROM enseignant_chercheur
								WHERE nom="'.$name.'"
								AND prenom="'.$surname.'"'
		);
		$row = $query->fetch();
		if($row) {
			return true;
		} else {
			return false;
		}
	}

	public function addAcademicResearcher($name, $surname, $office, $research_group) {
		$db = Database::getInstance();
		$query = $db->query('SELECT id FROM liste_pole WHERE libelle="'.$research_group.'"');
		$id_research_group = $query->fetch();

		$query->exec('INSERT INTO enseignant_chercheur(id_pole, nom, prenom, bureau) VALUES (
																						`'.$id_research_group->id.'`,
																						`'.$name.'`,
																						`'.$surname.'`,
																						`'.$office.'`)'
		);

		return $this->getData();
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

	public function purgeAcademicResearcherList() {
		$db = Database::getInstance();
		$db->exec('DELETE FROM conseiller');
		$db->exec('DELETE FROM enseignant_chercheur');

		return $this->getData();
	}

	public function deleteAcademicResearcher($name, $surname) {
		$db = Database::getInstance();
		$query = $db->query('	SELECT id FROM enseignant_chercheur 
								WHERE nom="'.$name.'" 
								AND prenom="'.$surname.'"'
				);
		$id_academic_researcher = $query->fetch();

		$db->exec('DELETE FROM conseiller WHERE id_enseignant_chercheur='.$id_academic_researcher->id);
		$db->exec('DELETE FROM enseignant_chercheur WHERE id='.$id_academic_researcher->id);

		return $this->getData();
	}


}

?>