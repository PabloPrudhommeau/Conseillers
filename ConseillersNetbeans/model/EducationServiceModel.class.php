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

	public function deleteStudent($student_name, $student_surname) {
		$db = Database::getInstance();
		$query = $db->query('	SELECT c.id_etudiant FROM etudiant AS etu
								LEFT JOIN conseiller AS c ON (c.id_etudiant=etu.id)
								WHERE etu.nom="'.$student_name.'"
								AND etu.prenom="'.$student_surname.'"'
				);
		$student_conseil = $query->fetch();

		if($student_conseil) {
			$db->exec('DELETE FROM conseiller WHERE id_etudiant='.$student_conseil->id_etudiant);
		}

		$db->exec('DELETE FROM etudiant WHERE id_etudiant='.$student_conseil->id_etudiant);

		return $this->getData();
	}

	public function alreadyExists($student_name, $student_surname) {
		$db = Database::getInstance();
		$query = $db->query('	SELECT etu.id FROM etudiant
								WHERE nom="'.$student_name.'"
								AND prenom="'.$student_surname.'"'
				);
		$row = $query->fetch();
		if($row) {
			return true;
		} else {
			return false;
		}	
	}

	public function addStudent($student_name, $student_surname, $program, $nb_semester) {
		$db = Database::getInstance();
		$query = $db->query('	SELECT id FROM liste_programme
								WHERE libelle="'.$program.'"'
				);
		$progam = $query->fetch();
		if($program) {
			$db->exec('INSERT INTO etudiant(id_programme, nom, prenom, semestre) VALUES (
																						`'.$program->id.'`,
																						`'.$student_name.'`,
																						`'.$student_surname.'`,
																						`'.$nb_semester.'`	
																						)'
			);
		}

		return $this->getData();
	}

	public function getFormation() {
		$db = Database::getInstance();
		$query = $db->query('	SELECT libelle FROM liste_programme
								WHERE libelle <> "TC" '
				);
		$row = $query->fetchAll();

		return $row;
	}

	public function  purgeStudentList() {
		$db = Database::getInstance();
		$db->exec('DELETE FROM conseiller');
		$db->exec('DELETE FROM etudiant');

		return $this->getData();
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
		$query = $db->query('	SELECT 	etu.id, 
										etu.id_programme,
										etu.nom AS student_name,
										etu.prenom AS student_surname
								FROM etudiant AS etu
								LEFT OUTER JOIN conseiller AS c ON (c.id_etudiant=etu.id)
								WHERE c.id_etudiant is NULL'
				);
		$student = $query->fetchAll();

		$query = $db->query ('	SELECT 	COUNT(c.id_enseignant_chercheur) AS nbetu, 
										ec.id, 
										ec.nom AS academic_researcher_name,
										ec.prenom AS academic_researcher_surname
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

		$assign_logs = array(array());
		$i = 0;

		foreach($student as $student_val) {
			$student_prog = $student_val->id_programme;
			foreach($academic_researcher as $academic_researcher_key => $academic_researcher_val) {
				foreach($authorization as $authorization_val) {
					if($authorization_val->id_enseignant_chercheur == $academic_researcher_val->id) {
						$academic_researcher_chosen = $academic_researcher_val->id;
						$academic_researcher_chosen_key = $academic_researcher_key;
						$found = true;
						break;
					}
				}
				if($found) break;
			}
			$db->exec('INSERT INTO conseiller(id_enseignant_chercheur, id_etudiant) VALUES('.$academic_researcher_chosen.', '.$student_val->id.')');
			$assign_logs[$i]['student_name'] = $student_val->student_name;
			$assign_logs[$i]['student_surname'] = $student_val->student_surname;
			$assign_logs[$i]['academic_researcher_name'] = $academic_researcher[$academic_researcher_chosen_key]->academic_researcher_name;
			$assign_logs[$i]['academic_researcher_surname'] = $academic_researcher[$academic_researcher_chosen_key]->academic_researcher_surname;
			$academic_researcher[$academic_researcher_chosen_key]->nbetu += 1;
			usort($academic_researcher, array('EducationServiceModel', 'etuCompare'));
			$academic_researcher_chosen = '';
			$found = false;
			$i++;
		}
		return $this->getData();
	}

}

?>
