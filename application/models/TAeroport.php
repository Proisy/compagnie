<?php
/**
 * Structure de la table:
 * 		aeroport_trigramme		VARCHAR
 * 		aeroport_nom			VARCHAR
 *  	aeroport_terminaux		INT
 *  	aeroport_longueur_piste	INT
 */
class TAeroport extends Zend_Db_Table_Abstract {

	protected $_name = 'aeroport';
	protected $_primary = 'aeroport_trigramme';

	/**
	 * Ajoute un aeroport
	 * @param array $data
	 */
	public function addAeroport($data) {
		$aeroport = $this->createRow();
		foreach ($data as $key => $value) {
			$aeroport->$key = $value;
		}
		$aeroport->save();
	}

	/**
	 * Modifie un aeroport
	 * @param int $id
	 * @param array $data
	 */
	public function editAeroport($id, $data) {
		$aeroport = $this->find($id)->current();
		foreach ($data as $key => $value) {
			$aeroport->$key = $value;
		}
		$aeroport->save();
	}

	/**
	 * Supprime un aeroport
	 * @param int $id
	 */
	public function deleteAeroport($id) {
		$aeroport = $this->find($id)->current();
		$aeroport->delete();
	}

	/**
	 * Récupère tous les aeroports
	 * @param array $columns
	 * @return array
	 */
	public function getAllAeroports($columns='*') {
		$requete = $this->select()->from($this, $columns);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère un aeroport selon son id
	 * @param int $id
	 * @param array $columns
	 * @return array
	 */
	public function getAeroport($id, $columns='*') {
		$requete = $this->select()->from($this, $columns)->where('aeroport_trigramme = ?', $id);
		$data = $this->fetchAll($requete)->toArray();
		return $data[0];
	}

	/**
	 * Récupère $maxInt-$minInt aeroports à partir du $minInt aeroport
	 * @param int $minInt
	 * @param int $maxInt
	 * @param array $columns
	 * @return array
	 */
	public function getSomeAeroports($page, $nbAeroport, $columns='*') {
		$requete = $this->select()->from($this, $columns)->limitPage($page,$nbAeroport);
		return $this->fetchAll($requete)->toArray();
	}

	public function countAeroport(){
			$requete = $this->select()->from($this, array('count(*) as nbAeroport'));
			$data = $this->fetchAll($requete);
			return $data[0]->nbAeroport; 
	}

	/**
	 * Récupère des aeroports en fonction des paramètres passés
	 * @param array $data
	 * @param array $columns
	 * @return array
	 *
	 * @todo à refaire
	 */
	public function getAeroportsBy($data, $columns='*') {
		$requete = $this->select()->from($this, $columns);
		foreach ($data as $arr) {
			$requete->where($arr['column']. ' ' .$arr['operator'] .' ?', $arr['value']);
		}
		return $this->fetchAll($requete)->toArray();
	}
}