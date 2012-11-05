<?php

class ModeleController extends Zend_Controller_Action
{
	public function init(){
		
	}

	public function indexAction(){
		// $this->view->listeModeles = $this->getAllModeles();   
		$tableModele = new TModele;
		// var_dump($tableModele->getModele(2));
		// var_dump($tableModele->getModelesBy(array('id_modele'=>'1')));
		var_dump($tableModele->getSomeModeles());
	}

	public function ajouterAction() {
		$tableModele = new TModele;
		$tableModele->addModele('Airbus', 'A380', 2500, 300, 450, 600, 800);
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