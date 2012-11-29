<?php
 
class LigneController extends Extension_Controller_Action
{
	public function init(){
		parent::init();
		$this->_helper->actionStack('menu', 'direction', 'default', array());
	}

	public function indexAction(){
		$page=$this->getRequest()->getParam('page');
		if(!isset($page)) {
			$page = 1;
		}
		$tableLigne = new TLigne;
		$tableAeroport = new TAeroport;
		$dataLigne = $tableLigne->getSomeLignes()
		// $this->view->listeLigne = $tableLigne->getSomeLignes($page,15);
		// $this->view->nbLigne = (($tableLigne->countLignes())/15);
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
		$listeInput['ligne_periodicite']->addMultiOptions(array('1' => 'Journalier', '2' => 'Hebdomadaire', '3' => 'mensuelle', '4' => 'Unique'));
		


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
		$tableligne = new Tligne;

		$form = new Zend_Form;

		$form->setAction('/ligne/modifier/id/'.$id)->setMethod('post');

		$listeInput['id_ligne'] = new Zend_Form_Element_Text('id_ligne');
		$listeInput['id_aeroport_depart'] = new Zend_Form_Element_Text('id_aeroport_depart');
		$listeInput['id_aeroport_arrivee'] = new Zend_Form_Element_Text('id_aeroport_arrivee');
		$listeInput['ligne_periodicite'] = new Zend_Form_Element_Text('ligne_periodicite');

		$listeInput['id_ligne']->setLabel('Trigramme')
						->addValidator(new Zend_Validate_Alpha())
						->addValidator(new Zend_Validate_StringLength(array('min'=>3,'max'=>3)));
		$listeInput['id_aeroport_depart']->setLabel('Nom')->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
		$listeInput['id_aeroport_arrivee']->setLabel('Nombre de terminaux')->addValidator(new Zend_Validate_Digits());
		$listeInput['ligne_periodicite']->setLabel('Longueur maximale de piste (en m)')->addValidator(new Zend_Validate_Digits());

		$dataOld = $tableligne->getligne($id);

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true)->setValue($dataOld[$key]);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();
				$tableligne->editligne($id,$data);
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