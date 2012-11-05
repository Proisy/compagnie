<?php
/**
 * Structure de la table:
 * 		id_certification_modele	INT
 * 		id_certification		INT
 * 		id_modele 				INT
 */
class TCertificationModele extends Zend_Db_Table_Abstract {

	protected $_name = 'certification_modele';
	protected $_primary = 'id_certification_modele';
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

	public function addLink($id_certification, $id_modele) {
		$certificationModele = $this->createRow();
		$certificationModele->id_certification = $id_certification;
		$certificationModele->id_modele = $id_modele;
		$certification->save();
	}

	public function deleteLink($id) {
		$certificationModele = $this->find($id)->current();
		$certificationModele->delete();
	}

	public function getAllLinks() {
		return $this->fetchAll()->toArray();
	}

	public function getLinksBy($data) {
		$requete = $this->select()->from($this);
		foreach ($data as $key => $value) {
			$requete->where($key.' = ?',$value);
		}
		return $this->fetchAll($requete)->toArray();
	}
}