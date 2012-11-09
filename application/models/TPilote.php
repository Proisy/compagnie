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
	public function getAllPilotes($columns='*') {
		$requete = $this->select()->from($this, $columns);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère un pilote selon son id
	 * @param int $id
	 * @return array
	 */
	public function getPilote($id,$columns='*') {
		$requete = $this->select()->from($this, $columns)->where('id_modele = ?', $id);
		$data = $this->fetchAll($requete)->toArray();
		return $data[0];
	}

	/**
	 * Récupère $maxInt-$minInt pilotes à partir du $minInt pilote
	 * @param int $minInt
	 * @param int $maxInt
	 * @return array
	 */
	public function getSomePilotes($minInt, $maxInt,$columns='*') {
		$requete = $this->select()->from($this, $columns)
			->order('id_modele')
			->limit($maxInt-$minInt, $minInt);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère des pilotes en fonction des paramètres passés
	 * @param array $data
	 * @return array
	 *
	 * @todo à refaire
	 */
	public function getPilotesBy($data,$columns='*') {
		$requete = $this->select()->from($this, $columns);
		foreach ($data as $arr) {
			$requete->where($arr['column']. ' ' .$arr['operator'] .' ?', $arr['value']);
		}
		return $this->fetchAll($requete)->toArray();
	}
}