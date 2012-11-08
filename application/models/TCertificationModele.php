<?php
/**
 * Structure de la table:
 * 		id_certification		INT
 * 		id_modele 				INT
 */
class TCertificationModele extends Zend_Db_Table_Abstract {

	protected $_name = 'certification_modele';
	protected $_primary = array('id_certification','id_modele');
	protected $_referenceMap = array(
		'Modele'=>array(
			'columns'=>'id_modele',
			'refTableClass'=>'TModele'
		),
		'Certification'=>array(
			'columns'=>'id_certification',
			'refTableClass'=>'TCertification'
		)
	);

	public function addLink($data) {
		$link = $this->createRow();
		foreach ($data as $key => $value) {
			$link->$key = $value;
		}
		$link->save();
	}

	public function removeLink($data) {
		$link = $this->find($data['id_certification'],$data['id_modele'])->current();
		$link->delete();
	}

	/**
	 * Teste si un lien entre une certification et un modèle existe
	 * @param  array $data
	 * @return boolean
	 */
	public function linkExists($data) {
		$link = $this->find($data['id_certification'],$data['id_modele'])->current();
		if(isset($link)){
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Récupère les modèles liées à la certification
	 * @param  string(3) $id_certification
	 * @return array
	 */
	public function getLinkedModeles($id_certification){
		$requete = $this->select()
					->setIntegrityCheck(false)
					->from(array('l'=>$this->_name))
					->join(array('m'=>'modele'), 'm.id_modele=l.id_modele')
					->where('id_certification = ?', $id_certification);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Retourne les modèles non liées à la certification
	 * @param  string(3) $id_certification
	 * @return array
	 */
	public function getUnlinkedModeles($id_certification) {
		$linkedModeles = $this->getLinkedModeles($id_certification);
		$listeModeles = array();	
		foreach ($linkedModeles as $modele) {
			array_push($listeModeles, $modele['id_modele']);
		}
		$requete = $this->select()
					->setIntegrityCheck(false)
					->from(array('m'=>'modele'), array('m.id_modele','m.modele_marque','m.modele_reference'))
					->where('m.id_modele NOT IN (?)', $listeModeles);
		return $this->fetchAll($requete)->toArray();
	}

	/**
	 * Récupère les certifications en fonction du modèle
	 * @param  int $id_ville
	 * @return array
	 */
	public function getLinkedCertifications($id_modele) {
		$requete = $this->select()
					->setIntegrityCheck(false)
					->from(array('l'=>$this->_name))
					->join(array('c'=>'certification'), 'c.id_certification=l.id_certification')
					->where('id_modele = ?', $id_modele);
		return $this->fetchAll($requete)->toArray();
	}
}