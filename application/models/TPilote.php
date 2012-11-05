<?php
/**
 * Structure de la table:
 * 		id_pilote				INT
 * 		id_user					INT
 */
class TPilote extends Zend_Db_Table_Abstract {

	protected $_name = 'pilote';
	protected $_primary = 'id_pilote';
	protected $_referenceMap = array(
		'User'=>array(
			'columns'=>'id_user',
			'refTableClass'=>'TUser'
		)
	);

	/**
	 * Ajoute un pilote
	 * @param array $data
	 */
	public function addPilote($data) {
		$pilote = $this->createRow();
		foreach ($data as $key => $value) {
			$pilote->$key = $value;
		}
		$pilote->save();
	}

	/**
	 * Modifie un pilote
	 * @param int $id
	 * @param array $data
	 */
	public function editPilote($id, $data) {
		$pilote = $this->find($id)->current();
		foreach ($data as $key => $value) {
			$pilote->$key = $value;
		}
		$pilote->save();
	}

	/**
	 * Supprime un pilote
	 * @param int $id
	 */
	public function deletePilote($id) {
		$pilote = $this->find($id)->current();
		$pilote->delete();
	}

	/**
	 * Récupère tous les pilotes
	 * @return array
	 */
	public function getAllPilotes() {
		return $this->fetchAll()->toArray();
	}

	/**
	 * Récupère $maxInt-$minInt pilotes à partir du $minInt pilote
	 * @param int $minInt
	 * @param int $maxInt
	 * @return array
	 */
	public function getSomePilotes($minInt, $maxInt) {
		$requete = $this->select()->from($this)
			->order('id_pilote')
			->limit($maxInt-$minInt, $minInt);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère un pilote selon son id
	 * @param int $id
	 * @return array
	 */
	public function getPilote($id) {
		return $this->find($id)->current()->toArray();
	}

	/**
	 * Récupère des pilotes en fonction des paramètres passés
	 * @param array $data
	 * @return array
	 *
	 * @todo à refaire
	 */
	public function getPilotesBy($data) {}
}