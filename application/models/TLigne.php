<?php
/**
 * Structure de la table:
 * 		id_ligne				INT
 * 		id_aeroport_depart		VARCHAR
 *		id_aeroport_arrivee		VARCHAR
 *		ligne_periodicite		ENUM
 */
class TLigne extends Zend_Db_Table_Abstract {

	protected $_name = 'ligne';
	protected $_primary = 'id_ligne';

	/**
	 * Ajoute une ligne
	 * @param array $data
	 */
	public function addLigne($data) {
		$ligne = $this->createRow();
		foreach ($data as $key => $value) {
			$ligne->$key = $value;
		}
		$ligne->save();
	}

	/**
	 * Modifie une ligne
	 * @param int $id
	 * @param array $data
	 */
	public function editLigne($id, $data) {
		$ligne = $this->find($id)->current();
		foreach ($data as $key => $value) {
			$ligne->$key = $value;
		}
		$ligne->save();
	}

	/**
	 * Supprime une ligne
	 * @param int $id
	 */
	public function deleteLigne($id) {
		$ligne = $this->find($id)->current();
		$ligne->delete();
	}

	/**
	 * Récupère tous les lignes
	 * @param array $columns
	 * @return array
	 */
	public function getAllLignes($columns='*') {
		$requete = $this->select()->from($this, $columns);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère toutes les lignes et les aéroports correspondants
	 * @return array
	 */
	public function getAllLignesFK() {
		$requete = $this->select()->from(array('l'=>$this->_name), array('l.id_ligne','l.ligne_periodicite'))
								->setIntegrityCheck(false)
								->join(array('d'=>'aeroport'),
									'd.aeroport_trigramme=l.trigramme_aeroport_depart', 
									array('trigramme_depart'=>'d.aeroport_trigramme',
										'aeroport_depart'=>'d.aeroport_nom')
									)
								->join(array('a'=>'aeroport'),
									'a.aeroport_trigramme=l.trigramme_aeroport_arrivee' ,
									array('trigramme_arrivee'=>'a.aeroport_trigramme',
										'aeroport_arrivee'=>'a.aeroport_nom')
									);
		return $this->fetchAll($requete)->toArray();
	}


	/**
	 * Récupère une ligne selon son id
	 * @param int $id
	 * @param array $columns
	 * @return array
	 */
	public function getLigne($id, $columns='*') {
		$requete = $this->select()->from($this, $columns)->where('id_ligne = ?', $id);
		$data = $this->fetchAll($requete)->toArray();
		return $data[0];
	}

	/**
	 * Récupère la n-ième page de lignes
	 * @param int $minInt
	 * @param int $maxInt
	 * @param array $columns
	 * @return array
	 */
	public function getSomeLignes($page, $nbligne, $columns='*') {
		$requete = $this->select()->setIntegrityCheck(false)
								->from(array('l'=>$this->_name, $columns))
								->join(array('a'=>'aeroport'), 'l.id_aeroport_depart = a.aeroport_trigramme', array('aeroport_nom'))
								->limitPage($page,$nbligne);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère la n-ième page de lignes et les aéroports correspondants
	 * @param  int $page    Numéro de page
	 * @param  int $nbligne Nombre de lignes par page
	 * @return array
	 */
	public function getSomeLignesFK($page, $nbligne) {
		$requete = $this->select()->from(array('l'=>$this->_name), array('l.id_ligne','l.ligne_periodicite'))
								->setIntegrityCheck(false)
								->join(array('d'=>'aeroport'),
									'd.aeroport_trigramme=l.trigramme_aeroport_depart', 
									array('trigramme_depart'=>'d.aeroport_trigramme',
										'aeroport_depart'=>'d.aeroport_nom')
									)
								->join(array('a'=>'aeroport'),
									'a.aeroport_trigramme=l.trigramme_aeroport_arrivee' ,
									array('trigramme_arrivee'=>'a.aeroport_trigramme',
										'aeroport_arrivee'=>'a.aeroport_nom')
									)
								->limitPage($page,$nbligne);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Retourne le nombre de lignes en base de données
	 * @return [type] [description]
	 */
	public function countLignes(){
			$requete = $this->select()->from($this, array('count(*) as nbLignes'));
			$data = $this->fetchAll($requete);
			return $data[0]->nbLignes; 
	}

	/**
	 * Récupère des lignes en fonction des paramètres passés
	 * @param array $data
	 * @param array $columns
	 * @return array
	 */
	public function getLignesBy($data, $columns='*') {
		$requete = $this->select()->from($this, $columns);
		foreach ($data as $arr) {
			$requete->where($arr['column']. ' ' .$arr['operator'] .' ?', $arr['value']);
		}
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère les lignes et les aéroports correspondants en fonction des paramètres passés
	 * @param  array $data		Paramètres de la recherche
	 * @return array
	 */
	public function getLignesFKBy($data) {
		$requete = $this->select()->from(array('l'=>$this->_name), array('l.id_ligne','l.ligne_periodicite'))
								->setIntegrityCheck(false)
								->join(array('d'=>'aeroport'),
									'd.aeroport_trigramme=l.trigramme_aeroport_depart', 
									array('trigramme_depart'=>'d.aeroport_trigramme',
										'aeroport_depart'=>'d.aeroport_nom')
									)
								->join(array('a'=>'aeroport'),
									'a.aeroport_trigramme=l.trigramme_aeroport_arrivee' ,
									array('trigramme_arrivee'=>'a.aeroport_trigramme',
										'aeroport_arrivee'=>'a.aeroport_nom')
									);
		foreach ($data as $arr) {
			$requete->where($arr['column']. ' ' .$arr['operator'] .' ?', $arr['value']);
		}
		return $this->fetchAll($requete)->toArray();
	}
}