<?php
/**
 * Structure de la table:
 * 		avion_immatriculation		INT
 * 		id_modele					INT
 *  	avion_heure_vol_total		INT
 *  	avion_heure_vol_revision	INT
 */
class TAvion extends Zend_Db_Table_Abstract {
	protected $_name = 'avion';
	protected $_primary = 'avion_immatriculation';
	protected $_referenceMap = array(
		'Modele'=>array(
			'columns'=>'id_modele',
			'refTableClass'=>'TModele'
		)
	);

	/**
	 * Ajoute un avion
	 * @param array $data
	 */
	public function addAvion($data) {
		$avion = $this->createRow();
		foreach ($data as $key => $value) {
			$avion->$key = $value;
		}
		$avion->save();
	}

	/**
	 * Modifie un avion
	 * @param int $id
	 * @param array $data
	 */
	public function editAvion($id, $data) {
		$avion = $this->find($id)->current();
		foreach ($data as $key => $value) {
			$avion->$key = $value;
		}
		$avion->save();
	}

	/**
	 * Supprime un avion
	 * @param int $id
	 */
	public function deleteAvion($id) {
		$avion = $this->find($id)->current();
		$avion->delete();
	}

	/**
	 * Récupère tous les avions
	 * @param array $columns
	 * @return array
	 */
	public function getAllAvions($columns='*') {
		$requete = $this->select()->from($this, $columns);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère un avion selon son id
	 * @param int $id
	 * @param array $columns
	 * @return array
	 */
	public function getAvion($id, $columns='*') {
		$requete = $this->select()->from($this, $columns)->where('avion_immatriculation = ?', $id);
		$data = $this->fetchAll($requete)->toArray();
		return $data[0];
	}

	/**
	 * Récupère $maxInt-$minInt avions à partir du $minInt avion
	 * @param int $minInt
	 * @param int $maxInt
	 * @param array $columns
	 * @return array
	 */
	public function getSomeAvions($minInt=0, $maxInt=20, $columns='*') {
		$requete = $this->select()->from($this, $columns)
			->order('avion_immatriculation')
			->limit($maxInt-$minInt, $minInt);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère des avions en fonction des paramètres passés
	 * @param array $data
	 * @param array $columns
	 * @return array
	 */
	public function getAvionsBy($data, $columns='*') {
		$requete = $this->select()->from($this, $columns);
		foreach ($data as $arr) {
			$requete->where($arr['column']. ' ' .$arr['operator'] .' ?', $arr['value']);
		}
		return $this->fetchAll($requete)->toArray();
	}
}