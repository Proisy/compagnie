<?php
 
class LigneController extends Extension_Controller_Action
{
	public function init(){
		parent::init();
	}

	public function indexAction(){
		$page=$this->getRequest()->getParam('page');
		if(!isset($page)) {
			$page = 1;
		}
		$tableLigne = new TLigne;
		$this->view->listeLignes = $tableLigne->getSomeLignesFK($page, 15);

		$this->view->nbPages = ($tableLigne->countLignes())/15;
	}

	public function viewAction() {
		$id = $this->getRequest()->getParam('id');
		if(!isset($id)){
			$redirector = $this->_helper->getHelper('redirector');
			$redirector->goToUrl('/ligne/');
		}
		else {
			$tableligne = new TLigne;
			$this->view->ligne = $tableLigne->getLigne($id);
		}
	}

		public function ajouterAction() {
		$form = new Zend_Form;
		$tableAeroport = new TAeroport;
		$tableLigne = new TLigne;
		$AllAeroport = $tableAeroport->getAllAeroports();

		$form->setAction('/ligne/ajouter/')->setMethod('post')->setAttrib('class', 'ligneAjouter');

		$listeInput['id_aeroport_depart'] = new Zend_Form_Element_Select('id_aeroport_depart');
		$listeInput['id_aeroport_arrivee'] = new Zend_Form_Element_Select('id_aeroport_arrivee');
		$listeInput['ligne_periodicite'] = new Zend_Form_Element_Select('ligne_periodicite');

		$listeInput['id_aeroport_depart']->setLabel('Aeroport de départ');
		$listeInput['id_aeroport_arrivee']->setLabel('Aeroport de arrivée');
		$listeInput['ligne_periodicite']->setLabel('Occurence du vol');
		foreach ($AllAeroport as $key => $value) {
			$listeInput['id_aeroport_depart']->addMultiOptions(array($value['aeroport_trigramme'] => $value['aeroport_nom']));
			$listeInput['id_aeroport_arrivee']->addMultiOptions(array($value['aeroport_trigramme'] => $value['aeroport_nom']));
		}
		$listeInput['ligne_periodicite']->addMultiOptions(array('journalier' => 'Journalier', 'hebdomadaire' => 'Hebdomadaire', 'mensuelle' => 'Mensuelle', 'unique' => 'Unique'));

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();
				$tableLigne = new TLigne;
				$tableLigne->addLigne($data);
				$this->_redirector->goToUrl('/ligne/');
			}
			else {
				$this->view->form = $form;
			}
		}
		else {
			$this->view->form = $form;
		}
	}

	public function modifierAction() {
		$id = $this->getRequest()->getParam('id');
		$tablePays = new TPays();
		$listePays = $tablePays->getAllPays();

		$tableAeroport = new TAeroport();
		$listeAeroports = $tableAeroport->getAllAeroports(array('aeroport_trigramme','aeroport_nom'));

		$tableLigne = new TLigne();
		$dataLigne = $tableLigne->getLigne($id);

		$form = new Zend_Form;

		$form->setAction('/ligne/modifier/id/'.$id)->setMethod('post');

		$listeInput['trigramme_aeroport_depart'] = new Zend_Form_Element_Select('trigramme_aeroport_depart');
		$listeInput['trigramme_aeroport_arrivee'] = new Zend_Form_Element_Select('trigramme_aeroport_arrivee');
		$listeInput['ligne_periodicite'] = new Zend_Form_Element_Select('ligne_periodicite');

		$listeInput['trigramme_aeroport_depart']->setLabel('Aéroport de départ')
										->addValidator(new Zend_Validate_Alpha())
										->addValidator(new Zend_Validate_StringLength(array('max' => 3, 'min'=>3)));
		$listeInput['trigramme_aeroport_arrivee']->setLabel('Aéroport d\'arrive')
										->addValidator(new Zend_Validate_Alpha())
										->addValidator(new Zend_Validate_StringLength(array('max' => 3, 'min'=>3)));

		foreach ($listeAeroports as $aeroport) {
			$listeInput['trigramme_aeroport_depart']->addMultiOptions(array($aeroport['aeroport_trigramme'] => $aeroport['aeroport_nom']));
			$listeInput['trigramme_aeroport_arrivee']->addMultiOptions(array($aeroport['aeroport_trigramme'] => $aeroport['aeroport_nom']));
		}

		$listeInput['ligne_periodicite']->setLabel('Périodicité')
										->addValidator(new Zend_Validate_Alpha())
										->addMultiOptions(array('journaliere' => 'Journalier', 'hebdomadaire' => 'Hebdomadaire', 'mensuelle' => 'Mensuelle', 'unique' => 'Unique'));

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true)->setValue($dataLigne[$key]);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();
				$tableLigne->editLigne($id,$data);
				$this->_redirector->goToUrl('/ligne/');
			}
			else {
				$this->view->form = $form;
			}
		}
		else {
			$this->view->form = $form;
		}
	}

	public function supprimerAction() {
		$id = $this->getRequest()->getParam('id');
		$tableligne = new Tligne;

		$form = new Zend_Form;

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$tableligne->deleteligne($id);
			$this->_redirector->goToUrl('/ligne/');
		}
		else {
			$this->view->dataligne = $tableligne->getligne($id);
		}
	}
}