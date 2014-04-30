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

	public function getFormation() {
		$db = Database::getInstance();
	}

	public function assignNewStudent($name, $firstname) {
		$db = Database::getInstance();
		$query = $db->query('	SELECT 	ec.id AS ec_id, 
										etu.id AS etu_id,
										COUNT(c.id_enseignant_chercheur) AS nbetu 
								FROM 	etudiant AS etu, 
										enseignant_chercheur AS ec
								LEFT JOIN conseiller AS c ON (c.id_enseignant_chercheur=ec.id)
								LEFT JOIN habilitation AS h ON (h.id_enseignant_chercheur=ec.id)
								WHERE etu.nom="SYRIAN"
								AND etu.prenom="Hafar"
								AND etu.id_programme=h.id_programme
								GROUP BY(c.id_enseignant_chercheur)
								ORDER BY nbetu ASC
								LIMIT 0,1'
				);
		$row = $query->fetch();

		$query->exec('INSERT INTO conseiller(id_enseignant_chercheur, id_etudiant) VALUES('.$row->ec_id.','.$row->etu_id.')');

		return $this->getData();
	}

	static function etuCompare($a, $b) {
	    if ($a == $b) {
	        return 0;
	    }
	    return ($a < $b) ? -1 : 1;
	}

	public function assignNewStudents() {
		$db = Database::getInstance();
		$query = $db->query('	SELECT etu.id, etu.id_programme 
								FROM etudiant AS etu
								LEFT OUTER JOIN conseiller AS c ON (c.id_etudiant=etu.id)
								WHERE c.id_etudiant is NULL'
				);
		$student = $query->fetchAll();

		$query = $db->query ('	SELECT COUNT(c.id_enseignant_chercheur) AS nbetu, ec.id
								FROM enseignant_chercheur AS ec
								LEFT JOIN conseiller AS c ON (c.id_enseignant_chercheur=ec.id)
								GROUP BY(c.id_enseignant_chercheur)
								ORDER BY nbetu'
				);
		$academic_researcher = $query->fetchAll();

		$query = $db->query (' 	SELECT h.* 
								FROM enseignant_chercheur AS ec
								LEFT JOIN habilitation AS h ON (h.id_enseignant_chercheur=ec.id)'
				);
		$authorization = $query->fetchAll();

		$found = false;

		foreach($student as $student_val) {
			$student_prog = $student_val->id_programme;
			foreach($academic_researcher as $academic_researcher_key => $academic_researcher_val) {
				foreach($authorization as $authorization_val) {
					if($authorization_val->id_enseignant_chercheur == $academic_researcher_val->id) {
						$academic_researcher_choose = $academic_researcher_val->id;
						$academic_researcher_choose_key = $academic_researcher_key;
						$found = true;
						break;
					}
				}
				if($found) break;
			}
			$db->exec('INSERT INTO conseiller(id_enseignant_chercheur, id_etudiant) VALUES('.$academic_researcher_choose.', '.$student_val->id.')');
			$academic_researcher[$academic_researcher_choose_key]->nbetu += 1;
			usort($academic_researcher, array('EducationServiceModel', 'etuCompare'));
			$academic_researcher_choose = '';
			$found = false;
		}


		return $this->getData();
	}

}

?>