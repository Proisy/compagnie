<?php
/**
 * Structure de la table:
 * 		id_modele				INT
 * 		modele_marque			VARCHAR
 *  	modele_reference		VARCHAR
 *  	modele_rayon			INT
 *  	modele_piste_att		INT
 *  	modele_piste_dec		INT
 *  	modele_nb_passagers		INT
 *  	modele_diff_revision	INT
 */
class TModele extends Zend_Db_Table_Abstract {

	protected $_name = 'modele';
	protected $_primary = 'id_modele';

	/**
	 * Créé un modèle
	 * @param array $data
	 */
	public function addModele($data) {
		$modele = $this->createRow();
		foreach ($data as $key => $value) {
			$modele->$key = $value;
		}
		$modele->save();
	}

	/**
	 * Modifie un modèle
	 * @param int $id
	 * @param array $data
	 */
	public function editModele($id, $data) {
		$modele = $this->find($id)->current();
		foreach ($data as $key => $value) {
			$modele->$key = $value;
		}
		$modele->save();
	}

	/**
	 * Supprime un modèle
	 * @param int $id
	 */
	public function deleteModele($id) {
		$modele = $this->find($id)->current();
		$modele->delete();
	}

	/**
	 * Récupère tous les modèles
	 * @return array
	 */
	public function getAllModeles($columns='*') {
		$requete = $this->select()->from($this, $columns);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère un modèle selon son idate(format)
	 * @param int $id
	 * @param array $columns
	 * @return array
	 */
	public function getModele($id,$columns='*') {
		$requete = $this->select()->from($this, $columns)->where('id_modele = ?', $id);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère $maxInt-$minInt modèles à partir du $minInt modèle
	 * @param int $minInt
	 * @param int $maxInt
	 * @param array $columns
	 * @return array
	 */
	public function getSomeModeles($minInt=0, $maxInt=20,$columns='*') {
		$requete = $this->select()->from($this, $columns)
			->order('id_modele')
			->limit($maxInt-$minInt, $minInt);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère des modèles en fonction des paramètres passés
	 * @param array $data
	 *        $data[] = array(
	 *        		'column' => ?,
	 *          	'operator' => ?,
	 *          	'value' => ? )
	 * @param array $columns
	 * @return array
	 */
	public function getModelesBy($data,$columns='*') {
		$requete = $this->select()->from($this, $columns);
		foreach ($data as $arr) {
			$requete->where($arr['column']. ' ' .$arr['operator'] .' ?', $arr['value']);
		}
		return $this->fetchAll($requete)->toArray();
	}
}