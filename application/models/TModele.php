<?php
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
	public function getAllModeles() {
		return $this->fetchAll()->toArray();
	}

	/**
	 * Récupère $maxInt-$minInt modèles à partir du $minInt modèle
	 * @param int $minInt
	 * @param int $maxInt
	 * @return array
	 */
	public function getSomeModeles($minInt=0, $maxInt=20) {
		$requete = $this->select()->from($this)
			->order('id_modele')
			->limit($maxInt-$minInt, $minInt);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère un modèle selon son id
	 * @param int $id
	 * @return array
	 */
	public function getModele($id) {
		return $this->find($id)->current()->toArray();
	}


	/**
	 * Récupère des modèles en fonction des paramètres passés
	 * @param array $data
	 * @return array
	 * 
	 * @todo à revoir
	 */
	public function getModelesBy($data) {
		if(is_array($data)){
			$requete = $this->select()->from($this);
			foreach ($data as $key => $value) {
				$requete->where($key.' = ?',$value);
			}
			return $this->fetchAll($requete)->toArray();
		}
	}
}