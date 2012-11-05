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
	 * @return array
	 */
	public function getAllPays() {
		return $this->fetchAll()->toArray();
	}

	/**
	 * Récupère un pays selon son id
	 * @param int $id
	 * @return array
	 */
	public function getPays($id) {
		return $this->find($id)->current()->toArray();
	}

	/**
	 * Récupère $maxInt-$minInt pays à partir du $minInt pays
	 * @param int $minInt
	 * @param int $maxInt
	 * @return array
	 */
	public function getSomePays($minInt, $maxInt) {
		$requete = $this->select()->from($this)
			->order('id_pays')
			->limit($maxInt-$minInt, $minInt);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère des pays en fonction des paramètres passés
	 * @param array $data
	 * @return array
	 *
	 * @todo à refaire
	 */
	public function getPaysBy($data) {}
}