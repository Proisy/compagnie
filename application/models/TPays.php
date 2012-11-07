<?php
/**
 * Structure de la table:
 * 		id_pays					INT
 * 		pays_nom				VARCHAR
 *  	pays_continent			VARCHAR
 */
class TPays extends Zend_Db_Table_Abstract {

	protected $_name = 'pays';
	protected $_primary = 'id_pays';

	/**
	 * Ajoute un pays
	 * @param array $data
	 */
	public function addPays($data) {
		$pays = $this->createRow();
		foreach ($data as $key => $value) {
			$pays->$key = $value;
		}
		$pays->save();
	}

	/**
	 * Modifie un pays
	 * @param int $id
	 * @param array $data
	 */
	public function editPays($id, $data) {
		$pays = $this->find($id)->current();
		foreach ($data as $key => $value) {
			$pays->$key = $value;
		}
		$pays->save();
	}

	/**
	 * Supprime un pays
	 * @param int $id
	 */
	public function deletePays($id) {
		$pays = $this->find($id)->current();
		$pays->delete();
	}

	/**
	 * Récupère tous les pays
	 * @param array $columns
	 * @return array
	 */
	public function getAllPays($columns='*') {
		$requete = $this->select()->from($this, $columns);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère un pays selon son id
	 * @param int $id
	 * @return array
	 */
	public function getPays($id, $columns='*') {
		$requete = $this->select()->from($this, $columns)->where('id_pays = ?', $id);
		$data = $this->fetchAll($requete)->toArray();
		return $data[0];
	}

	/**
	 * Récupère $maxInt-$minInt pays à partir du $minInt pays
	 * @param int $minInt
	 * @param int $maxInt
	 * @param array $columns
	 * @return array
	 */
	public function getSomePays($minInt, $maxInt, $columns='*') {
		$requete = $this->select()->from($this, $columns)
			->order('id_pays')
			->limit($maxInt-$minInt, $minInt);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère des pays en fonction des paramètres passés
	 * @param array $data
	 *        $data[] = array(
	 *        		'column' => ?,
	 *          	'operator' => ?,
	 *          	'value' => ? )
	 * @param array $columns
	 * @return array
	 */
	public function getPaysBy($data, $columns='*') {
		$requete = $this->select()->from($this, $columns);
		foreach ($data as $arr) {
			$requete->where($arr['column']. ' ' .$arr['operator'] .' ?', $arr['value']);
		}
		return $this->fetchAll($requete)->toArray();
	}
}