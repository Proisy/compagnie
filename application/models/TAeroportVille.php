<?php
/**
 * Structure de la table:
 * 		aeroport_trigramme		VARCHAR(3)
 *  	id_ville				INT
 */
class TAeroportVille extends Zend_Db_Table_Abstract {

	protected $_name = 'aeroport_ville';
	protected $_primary = array('aeroport_trigramme', 'id_ville');
	protected $_referenceMap = array(
		'Aeroport'=>array(
			'columns'=>'aeroport_trigramme',
			'refTableClass'=>'TAeroport'
		),
		'Ville'=>array(
			'columns'=>'id_ville',
			'refTableClass'=>'TVille'
		)
	);

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
	 * Teste si un lien entre un aéroport et une ville existe
	 * @param  array $data
	 * @return boolean
	 */
	public function linkExists($data) {
		$link = $this->find($data['aeroport_trigramme'],$data['id_ville'])->current();
		if(isset($link)){
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Récupère les villes liées à l'aéroport
	 * @param  string(3) $aeroport_trigramme
	 * @return array
	 */
	public function getLinkedVilles($aeroport_trigramme){
		$requete = $this->select()
					->setIntegrityCheck(false)
					->from(array('l'=>$this->_name), array('id_ville'))
					->join(array('v'=>'ville'), 'v.id_ville=l.id_ville')
					->join(array('p'=>'pays'),'v.id_pays=p.id_pays')
					->where('aeroport_trigramme = ?', $aeroport_trigramme);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Retourne les villes non liées à l'aéroport
	 * @param  string(3) $aeroport_trigramme
	 * @return array
	 */
	public function getUnlinkedVilles($aeroport_trigramme) {
		$linkedVilles = $this->getLinkedVilles($aeroport_trigramme);
		$listeVilles = array();
		foreach ($linkedVilles as $ville) {
			array_push($listeVilles, $ville['id_ville']);
		}
		$requete = $this->select()
					->setIntegrityCheck(false)
					->from(array('v'=>'ville'), array('v.id_ville','v.ville_nom'))
					->from(array('p'=>'pays'), array('p.pays_nom'))
					->where('v.id_ville NOT IN (?)', $listeVilles)
					->where('v.id_pays=p.id_pays');
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère les aéroports qui désservent la ville
	 * @param  int $id_ville
	 * @return array
	 */
	public function getLinkedAeroports($id_ville) {
		$requete = $this->select()
					->setIntegrityCheck(false)
					->from(array('l'=>$this->_name))
					->join(array('a'=>'aeroport'), 'a.aeroport_trigramme=l.aeroport_trigramme')
					->where('id_ville = ?', $id_ville);
		return $this->fetchAll($requete)->toArray();
	}
}