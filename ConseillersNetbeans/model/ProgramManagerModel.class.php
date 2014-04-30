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
}

?>