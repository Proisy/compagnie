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
	 * @return array
	 */
	public function getAllAeroport() {
		return $this->fetchAll()->toArray();
	}

	/**
	 * Récupère un aeroport selon son id
	 * @param int $id
	 * @return array
	 */
	public function getAeroport($id) {
		return $this->find($id)->current()->toArray();
	}

	/**
	 * Récupère $maxInt-$minInt aeroports à partir du $minInt aeroport
	 * @param int $minInt
	 * @param int $maxInt
	 * @return array
	 */
	public function getSomeAeroport($minInt, $maxInt) {
		$requete = $this->select()->from($this)
			->order('id_aeroport')
			->limit($maxInt-$minInt, $minInt);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère des aeroports en fonction des paramètres passés
	 * @param array $data
	 * @return array
	 *
	 * @todo à refaire
	 */
	public function getAeroportBy($data) {}
}