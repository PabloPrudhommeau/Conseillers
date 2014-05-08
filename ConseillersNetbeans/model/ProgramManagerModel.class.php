<?php

class ProgramManagerModel {

	public function getData() {
		$db = Database::getInstance();
		$query = $db->query('	SELECT DISTINCT ec.id, ec.prenom, ec.nom, ec.bureau, lp.libelle
								FROM enseignant_chercheur AS ec
								LEFT JOIN habilitation AS h ON ( h.id_enseignant_chercheur = ec.id )
								LEFT JOIN liste_programme AS lp ON ( lp.id = h.id_programme )
								ORDER BY ec.id'
							);
		$row = $query->fetchAll();
		$prog = array();
		$id = $row[0]->id;
		$data = array();

		//Mise en conformité du tableau
		for($i = 0; $i < count($row); $i++) {
			if($id == $row[$i]->id) {
				$prog[] = $row[$i]->libelle;
			} else {
				$row[$i-1]->libelle = $prog;
				$data[] = $row[$i-1];
				unset($prog);
				$prog[] = $row[$i]->libelle;
			}
			$id = $row[$i]->id;
		}

		$row[count($row)-1]->libelle = $prog;
		$data[] = $row[count($row)-1];
		
		for($i = 0; $i < count($data); $i++) {
			unset($data[$i]->id);
		}
		
		return $data;
	}

	public function addAuthorization($teacher_name, $teacher_surname, $label_authorization) {
		$db = Database::getInstance();
		$query = $db->query('	SELECT id FROM enseignant_chercheur
								WHERE nom="'.$teacher_name.'"
								AND prenom="'.$teacher_surname.'"'
				);
		$id_teacher = $query->fetch();

		$query = $db->query('SELECT id FROM liste_programme WHERE libelle="'.$label_authorization.'"');
		$id_authorization = $query->fetch();

		$db->exec('INSERT INTO habilitation(id_enseignant_chercheur, id_programme) VALUES(
																						`'.$id_teacher->id.'`,
																						`'.$id_authorization->id.'`)'
		);

		return $this->getData();
	}

	public function addHabilitationByGroup($group, $label_authorization) {
		$db = Database::getInstance();
		$query = $db->query('SELECT id FROM liste_programme WHERE libelle="'.$label_authorization.'"');
		$id_authorization = $query->fetch();

		$query = $db->query('SELECT id FROM liste_pole WHERE libelle="'.$groupe.'"');
		$id_group = $query->fetch();

		$query = $db->query('SELECT id FROM enseignant_chercheur WHERE id_pole='.$id_group->id);
		$id_teacher = $query->fetchAll();

		foreach($id_teacher as $value) {
			$db->exec('INSERT INTO habilitation(id_enseignant_chercheur, id_programme) VALUES(
																							`'.$value->id.'`,
																							`'.$id_authorization->id.'`)'
			);
		}

		return $this->getData();
	} 

	public function deleteAuthorization($teacher_name, $teacher_surname, $label_authorization) {
		$db = Database::getInstance();
		$query = $db->query('	SELECT id FROM enseignant_chercheur
								WHERE nom="'.$teacher_name.'"
								AND prenom="'.$teacher_surname.'"'
				);
		$id_teacher = $query->fetch();

		$query = $db->query('SELECT id FROM liste_programme WHERE libelle="'.$label_authorization.'"');
		$id_authorization = $query->fetch();

		$db->exec('DELETE FROM habilitation WHERE id_enseignant_chercheur='.$id_teacher->id.' AND id_programme='.$id_authorization->id);

		return $this->getData();
	}

}

?>