<?php
/**
 * Structure de la table:
 * 		id_certification		INT
 * 		certification_nom		VARCHAR
 *  	certification_validité	INT
 */
class TCertification extends Zend_Db_Table_Abstract {

	protected $_name = 'certification';
	protected $_primary = 'id_certification';

	/**
	 * Ajoute une certification
	 * @param array $data
	 */
	public function addCertification($data) {
		$certification = $this->createRow();
		foreach ($data as $key => $value) {
			$certification->$key = $value;
		}
		$certification->save();
	}

	/**
	 * Modifie une certification
	 * @param int $id
	 * @param array $data
	 */
	public function editCertification($id, $data) {
		$certification = $this->find($id)->current();
		foreach ($data as $key => $value) {
			$certification->$key = $value;
		}
		$certification->save();
	}

	/**
	 * Supprime une certification
	 * @param int $id
	 */
	public function deleteCertification($id) {
		$certification = $this->find($id)->current();
		$certification->delete();
	}

	/**
	 * Récupère toutes les certifications
	 * @return array
	 */
	public function getAllCertifications($columns='*') {
		$requete = $this->select()->from($this, $columns);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère une certification selon son id
	 * @param int $id
	 * @return array
	 */
	public function getCertification($id,$columns='*') {
		$requete = $this->select()->from($this, $columns)->where('id_certification = ?', $id);
		$data = $this->fetchAll($requete)->toArray();
		return $data[0];
	}

	/**
	 * Récupère $maxInt-$minInt certifications à partir du $minInt certification
	 * @param int $minInt
	 * @param int $maxInt
	 * @return array
	 */
	public function getSomeCertifications($minInt, $maxInt, $columns='*') {
		$requete = $this->select()->from($this, $columns)
			->order('id_certification')
			->limit($maxInt-$minInt, $minInt);
		return $this->fetchAll($requete)->toArray();
	}


	/**
	 * Récupère des certifications en fonction des paramètres passés
	 * @param array $data
	 * @return array
	 *
	 * @todo à refaire
	 */
	public function getCertificationsBy($data, $columns='*') {
		$requete = $this->select()->from($this, $columns);
		foreach ($data as $arr) {
			$requete->where($arr['column']. ' ' .$arr['operator'] .' ?', $arr['value']);
		}
		return $this->fetchAll($requete)->toArray();
	}
}