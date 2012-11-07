<?php
/**
 * Structure de la table:
 * 		id_ville				INT
 * 		ville_nom				VARCHAR
 *  	id_pays					INT
 */
class TVille extends Zend_Db_Table_Abstract {

	protected $_name = 'ville';
	protected $_primary = 'id_ville';
	protected $_referenceMap = array(
		'Pays'=>array(
			'columns'=>'id_pays',
			'refTableClass'=>'TPays'
		)
	);

	/**
	 * Ajoute une ville
	 * @param array $data
	 */
	public function addVille($data) {
		$ville = $this->createRow();
		foreach ($data as $key => $value) {
			$ville->$key = $value;
		}
		$ville->save();
	}

	/**
	 * Modifie une ville
	 * @param int $id
	 * @param array $data
	 */
	public function editVille($id, $data) {
		$ville = $this->find($id)->current();
		foreach ($data as $key => $value) {
			$ville->$key = $value;
		}
		$ville->save();
	}

	/**
	 * Supprime une ville
	 * @param int $id
	 */
	public function deleteVille($id) {
		$ville = $this->find($id)->current();
		$ville->delete();
	}

	/**
	 * Récupère tous les villes
	 * @return array
	 */
	public function getAllVille($columns='*') {
		$requete = $this->select()->from($this, $columns);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère une ville selon son id
	 * @param int $id
	 * @return array
	 */
	public function getVille($id, $columns='*') {
		$requete = $this->select()->from($this, $columns)->where('id_ville = ?', $id);
		$data = $this->fetchAll($requete)->toArray();
		return $data[0];
	}

	/**
	 * Récupère $maxInt-$minInt villes à partir du $minInt ville
	 * @param int $minInt
	 * @param int $maxInt
	 * @return array
	 */
	public function getSomeVille($minInt, $maxInt, $columns='*') {
		$requete = $this->select()->from($this, $columns)
			->order('id_ville')
			->limit($maxInt-$minInt, $minInt);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère des villes en fonction des paramètres passés
	 * @param array $data
	 * @return array
	 *
	 * @todo à refaire
	 */
	public function getVilleBy($data, $columns='*') {
		$requete = $this->select()->from($this, $columns);
		foreach ($data as $arr) {
			$requete->where($arr['column']. ' ' .$arr['operator'] .' ?', $arr['value']);
		}
		return $this->fetchAll($requete)->toArray();
	}
}