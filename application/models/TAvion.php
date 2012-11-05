<?php
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
	 * @return array
	 */
	public function getAllAvions() {
		return $this->fetchAll()->toArray();
	}

	/**
	 * Récupère $maxInt-$minInt avions à partir du $minInt avion
	 * @param int $minInt
	 * @param int $maxInt
	 * @return array
	 */
	public function getSomeAvions($minInt, $maxInt) {
		$requete = $this->select()->from($this)
			->order('id_avion')
			->limit($maxInt-$minInt, $minInt);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère un avion selon son id
	 * @param int $id
	 * @return array
	 */
	public function getAvion($id) {
		return $this->find($id)->current()->toArray();
	}

	/**
	 * Récupère des avions en fonction des paramètres passés
	 * @param array $data
	 * @return array
	 *
	 * @todo à refaire
	 */
	public function getAvionsBy($data) {}
}