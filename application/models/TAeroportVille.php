<?php
/**
 * Structure de la table:
 * 		aeroport_trigramme		VARCHAR(3)
 *  	id_ville				INT
 */
class TAeroportVille extends Zend_Db_Table_Abstract {

	protected $_name = 'aeroport_ville';
	protected $_primary = array('aeroport_trigramme', 'id_ville');

	/**
	 * Ajoute un lien entre un aéroport et une ville
	 * @param array $data
	 */
	public function addLink($data) {
		$link = $this->createRow();
		foreach ($data as $key => $value) {
			$link->$key = $value;
		}
		$link->save();
	}

	/**
	 * Supprime un lien entre un aéroport et une ville
	 * @param int $id
	 */
	public function removeLink($data) {
		$link = $this->find($data['aeroport_trigramme'],$data['id_ville'])->current();

		$link->delete();
	}

	/**
	 * Récupère les villes désservies par un certain aéroport
	 * @param varchar(3) $aeroport_trigramme
	 * @return array
	 */
	public function getAeroportLinks($aeroport_trigramme) {
		$requete = $this->select()->from($this, $columns)->where('aeroport_trigramme = ?', $aeroport_trigramme);
		$listeVilles = $this->fetchAll($requete)->toArray();
		var_dump($listeVilles);

		// $tableVilles = new TVille();
		// $tableVilles->getManyVilles()
	}

	/**
	 * Récupère les aéroports qui désservent une certaine ville
	 * @param int $id_ville
	 * @param array $columns
	 * @return array
	 */
	public function getVilleLinks($id_ville) {
		$requete = $this->select()->from($this, $columns)->where('id_ville = ?', $aeroport_trigramme);
		return $this->fetchAll($requete)->toArray();
	}
}