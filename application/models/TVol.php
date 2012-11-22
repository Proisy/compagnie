<?php
/**
 * Structure de la table:
 * 		id_vol				INT
 * 		id_pilote			INT
 *		id_copilote 		INT
 *		vol_informations	VARCHAR
 *		vol_date			DATE
 *		vol_depart_prevu	TIME
 *		vol_arrivee_prevue 	TIME
 *		id_ligne			INT
 */
class TVol extends Zend_Db_Table_Abstract {

	protected $_name = 'vols';
	protected $_primary = 'id_vol';

	/**
	 * Ajoute un vol
	 * @param array $data
	 */
	public function addVol($data) {
		$vol = $this->createRow();
		foreach ($data as $key => $value) {
			$vol->$key = $value;
		}
		$vol->save();
	}

	/**
	 * Modifie un vol
	 * @param int $id
	 * @param array $data
	 */
	public function editVol($id, $data) {
		$vol = $this->find($id)->current();
		foreach ($data as $key => $value) {
			$vol->$key = $value;
		}
		$vol->save();
	}

	/**
	 * Supprime un vol
	 * @param int $id
	 */
	public function deleteVol($id) {
		$vol = $this->find($id)->current();
		$vol->delete();
	}

	/**
	 * Récupère tous les vol
	 * @param array $columns
	 * @return array
	 */
	public function getAllVols($columns='*') {
		$requete = $this->select()->from($this, $columns);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère un vol selon son id
	 * @param int $id
	 * @param array $columns
	 * @return array
	 */
	public function getVol($id, $columns='*') {
		$requete = $this->select()->from($this, $columns)->where('id_vol = ?', $id);
		$data = $this->fetchAll($requete)->toArray();
		return $data[0];
	}

	/**
	 * Récupère $maxInt-$minInt vols à partir du $minInt vol
	 * @param int $minInt
	 * @param int $maxInt
	 * @param array $columns
	 * @return array
	 */
	public function getSomeVols($page, $nbVol, $columns='*') {
		$requete = $this->select()->from($this, $columns)->limitPage($page,$nbVol);
		return $this->fetchAll($requete)->toArray();
	}

	public function countVols(){
			$requete = $this->select()->from($this, array('count(*) as $nbVols'));
			$data = $this->fetchAll($requete);
			return $data[0]->$nbVols; 
	}

	/**
	 * Récupère des vols en fonction des paramètres passés
	 * @param array $data
	 * @param array $columns
	 * @return array
	 *
	 * @todo à refaire
	 */
	public function getVolsBy($data, $columns='*') {
		$requete = $this->select()->from($this, $columns);
		foreach ($data as $arr) {
			$requete->where($arr['column']. ' ' .$arr['operator'] .' ?', $arr['value']);
		}
		return $this->fetchAll($requete)->toArray();
	}
}