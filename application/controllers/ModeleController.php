<?php

class ModeleController extends Zend_Controller_Action
{
	public function init(){
		
	}

	public function indexAction(){
		// $this->view->listeModeles = $this->getAllModeles();   
		$tableModele = new TModele;
		// var_dump($tableModele->getModele(2));
		// var_dump($tableModele->getSomeModeles());
		var_dump($tableModele->getModelesBy(array(
				array('column' => 'modele_rayon',
					'operator' => '>=',
					'value' => '1900' )
				)
			)
		);
	}

	public function ajouterAction() {
		$tableModele = new TModele;
		$data = array('modele_marque'=>'Airbus','modele_reference'=>'A310','modele_rayon'=>1900,'modele_piste_att'=>300,'modele_piste_dec'=>250,'modele_nb_passagers'=>300,'modele_diff_revision'=>600);
		$tableModele->addModele($data);
	}

	public function modifierAction() {
		$tableModele = new TModele;
		$arr = array(
			'modele_marque' => 'Boeing'
			);
		$tableModele->editModele(2,$arr);
	}

	public function supprimerAction() {
		
	}
}