<?php
/**
 * Structure de la table:
 * 		id_user					INT
 * 		user_nom				VARCHAR(255)
 *  	user_prenom				VARCHAR(255)
 *  	user_adresse			VARCHAR(255)
 *  	user_telephone			VARCHAR(12)
 */
class TUser extends Zend_Db_Table_Abstract {

	protected $_name = 'user';
	protected $_primary = 'id_user';

	/**
	 * Ajoute un utilisateur
	 * @param array $data
	 */
	public function addUser($data) {
		$user = $this->createRow();
		foreach ($data as $key => $value) {
			$user->$key = $value;
		}
		$user->save();
	}

	/**
	 * Modifie un utilisateur
	 * @param int $id
	 * @param array $data
	 */
	public function editUser($id, $data) {
		$user = $this->find($id)->current();
		foreach ($data as $key => $value) {
			$user->$key = $value;
		}
		$user->save();
	}

	/**
	 * Supprime un utilisateur
	 * @param int $id
	 */
	public function deleteUser($id) {
		$user = $this->find($id)->current();
		$user->delete();
	}

	/**
	 * Récupère tous les utilisateurs
	 * @return array
	 */
	public function getAllUsers($columns='*') {
		$requete = $this->select()->from($this, $columns);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère un utilisateur selon son id
	 * @param int $id
	 * @return array
	 */
	public function getUser($id,$columns='*') {
		$requete = $this->select()->from($this, $columns)->where('id_user = ?', $id);
		$data = $this->fetchAll($requete)->toArray();
		return $data[0];
	}

	/**
	 * Récupère $maxInt-$minInt utilisateurs à partir du $minInt utilisateur
	 * @param int $minInt
	 * @param int $maxInt
	 * @return array
	 */
	public function getSomeUsers($minInt, $maxInt,$columns='*') {
		$requete = $this->select()->from($this, $columns)
			->order('id_user')
			->limit($maxInt-$minInt, $minInt);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère des utilisateurs en fonction des paramètres passés
	 * @param array $data
	 * @return array
	 *
	 * @todo à refaire
	 */
	public function getUsersBy($data,$columns='*') {
		$requete = $this->select()->from($this, $columns);
		foreach ($data as $arr) {
			$requete->where($arr['column']. ' ' .$arr['operator'] .' ?', $arr['value']);
		}
		return $this->fetchAll($requete)->toArray();
	}
}