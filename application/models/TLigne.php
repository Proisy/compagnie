<?php
/**
 * Structure de la table:
 * 		id_ligne				INT
 * 		id_aeroport_depart		VARCHAR
 *		id_aeroport_arrivee		VARCHAR
 *		ligne_periodicite		ENUM
 */
class TLigne extends Zend_Db_Table_Abstract {

	protected $_name = 'ligne';
	protected $_primary = 'id_ligne';

	/**
	 * Ajoute un ligne
	 * @param array $data
	 */
	public function addligne($data) {
		$ligne = $this->createRow();
		foreach ($data as $key => $value) {
			$ligne->$key = $value;
		}
		$ligne->save();
	}

	/**
	 * Modifie un ligne
	 * @param int $id
	 * @param array $data
	 */
	public function editligne($id, $data) {
		$ligne = $this->find($id)->current();
		foreach ($data as $key => $value) {
			$ligne->$key = $value;
		}
		$ligne->save();
	}

	/**
	 * Supprime un ligne
	 * @param int $id
	 */
	public function deleteligne($id) {
		$ligne = $this->find($id)->current();
		$ligne->delete();
	}

	/**
	 * Récupère tous les ligne
	 * @param array $columns
	 * @return array
	 */
	public function getAllLignes($columns='*') {
		$requete = $this->select()->from($this, $columns);
		return $this->fetchAll($requete)->toArray();
	}
	public function getAllLigAerop($triD, $triA) {
		$requete = $this->select()->from(array('l'=>$this->_name))
								  ->setIntegrityCheck(false)
								  ->join(array('a'=>'aeroport'), 'l.id_aeroport_depart = a.aeroport_trigramme', array('a.aeroport_nom'))
								  //->join(array('a'=>'aeroport'), 'l.id_aeroport_arrivee = a.aeroport_trigramme', array('a.aeroport_nom'))
								  ->where('a.aeroport_trigramme = ? ', $triD)
								  ->where('a.aeroport_trigramme = ? ', $triA);
								  echo $requete;exit();
		return $this->fetchAll($requete)->toArray();
	}


	/**
	 * Récupère un ligne selon son id
	 * @param int $id
	 * @param array $columns
	 * @return array
	 */
	public function getligne($id, $columns='*') {
		$requete = $this->select()->from($this, $columns)->where('id_ligne = ?', $id);
		$data = $this->fetchAll($requete)->toArray();
		return $data[0];
	}

	/**
	 * Récupère $maxInt-$minInt lignes à partir du $minInt ligne
	 * @param int $minInt
	 * @param int $maxInt
	 * @param array $columns
	 * @return array
	 */
	public function getSomelignes($page, $nbligne, $columns='*') {
		$requete = $this->select()->from($this, $columns)->limitPage($page,$nbligne);
		return $this->fetchAll($requete)->toArray();
	}

	public function countlignes(){
			$requete = $this->select()->from($this, array('count(*) as $nblignes'));
			$data = $this->fetchAll($requete);
			return $data[0]->$nblignes; 
	}

	/**
	 * Récupère des lignes en fonction des paramètres passés
	 * @param array $data
	 * @param array $columns
	 * @return array
	 *
	 * @todo à refaire
	 */
	public function getlignesBy($data, $columns='*') {
		$requete = $this->select()->from($this, $columns);
		foreach ($data as $arr) {
			$requete->where($arr['column']. ' ' .$arr['operator'] .' ?', $arr['value']);
		}
		return $this->fetchAll($requete)->toArray();
	}
}