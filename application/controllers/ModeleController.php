<?php

class ModeleController extends Zend_Controller_Action
{
	public function init(){}

	public function indexAction(){
		$this->_helper->actionStack('menu', 'maintenance', 'default', array());
		$tableModele = new TModele;
		$this->view->listeModeles = $tableModele->getAllModeles();
	}

	public function viewAction() {
		$id = $this->getRequest()->getParam('id');
		if(!isset($id)){
			$redirector = $this->_helper->getHelper('redirector');
			$redirector->goToUrl('/avion/');
		}
	}

	public function ajouterAction() {
		$this->_helper->actionStack('menu', 'maintenance', 'default', array());
		$form = new Zend_Form;

		$form->setAction('/modele/ajouter/')->setMethod('post');

		$listeInput['modele_marque'] = new Zend_Form_Element_Text('modele_marque');
		$listeInput['modele_reference'] = new Zend_Form_Element_Text('modele_reference');
		$listeInput['modele_rayon'] = new Zend_Form_Element_Text('modele_rayon');
		$listeInput['modele_piste_att'] = new Zend_Form_Element_Text('modele_piste_att');
		$listeInput['modele_piste_dec'] = new Zend_Form_Element_Text('modele_piste_dec');
		$listeInput['modele_nb_passagers'] = new Zend_Form_Element_Text('modele_nb_passagers');
		$listeInput['modele_diff_revision'] = new Zend_Form_Element_Text('modele_diff_revision');

		$listeInput['modele_marque']->setLabel('Marque')
									->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
		$listeInput['modele_reference']->setLabel('Référence')
									->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
		$listeInput['modele_rayon']->setLabel('Rayon (en km)')
									->addValidator(new Zend_Validate_Digits());
		$listeInput['modele_piste_att']->setLabel('Longueur nécessaire pour l\'atterissage')
									->addValidator(new Zend_Validate_Digits());
		$listeInput['modele_piste_dec']->setLabel('Longueur nécessaire pour le décollage')
									->addValidator(new Zend_Validate_Digits());
		$listeInput['modele_nb_passagers']->setLabel('Nombre de passagers')
									->addValidator(new Zend_Validate_Digits());
		$listeInput['modele_diff_revision']->setLabel('Durée entre deux révisions')
									->addValidator(new Zend_Validate_Digits());

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$data = $form->getValues();

			$tableModele = new TModele;
			$tableModele->addModele($data);
		}
		else {
			$this->view->form = $form;
		}
	}

	public function modifierAction() {
		$this->_helper->actionStack('menu', 'maintenance', 'default', array());
		$id = $this->getRequest()->getParam('id');
		$tableModele = new TModele;

		$form = new Zend_Form;

		$form->setAction('/modele/modifier/id/'.$id)->setMethod('post');

		$listeInput['modele_marque'] = new Zend_Form_Element_Text('modele_marque');
		$listeInput['modele_reference'] = new Zend_Form_Element_Text('modele_reference');
		$listeInput['modele_rayon'] = new Zend_Form_Element_Text('modele_rayon');
		$listeInput['modele_piste_att'] = new Zend_Form_Element_Text('modele_piste_att');
		$listeInput['modele_piste_dec'] = new Zend_Form_Element_Text('modele_piste_dec');
		$listeInput['modele_nb_passagers'] = new Zend_Form_Element_Text('modele_nb_passagers');
		$listeInput['modele_diff_revision'] = new Zend_Form_Element_Text('modele_diff_revision');

		$listeInput['modele_marque']->setLabel('Marque')
									->addValidator(new Zend_Validate_Digits());
		$listeInput['modele_reference']->setLabel('Référence')
									->addValidator(new Zend_Validate_Digits());
		$listeInput['modele_rayon']->setLabel('Rayon (en km)')
									->addValidator(new Zend_Validate_Digits());
		$listeInput['modele_piste_att']->setLabel('Longueur nécessaire pour l\'atterissage')
									->addValidator(new Zend_Validate_Digits());
		$listeInput['modele_piste_dec']->setLabel('Longueur nécessaire pour le décollage')
									->addValidator(new Zend_Validate_Digits());
		$listeInput['modele_nb_passagers']->setLabel('Nombre de passagers')
									->addValidator(new Zend_Validate_Digits());
		$listeInput['modele_diff_revision']->setLabel('Durée entre deux révisions')
									->addValidator(new Zend_Validate_Digits());
		$dataOld = $tableModele->getModele($id);

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true)->setValue($dataOld[$key]);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));
		
		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$data = $form->getValues();

			$tableModele->editModele($id,$data);
		}
		else {
			$this->view->form = $form;
		}
	}

	public function supprimerAction() {
		$this->_helper->actionStack('menu', 'maintenance', 'default', array());
		$id = $this->getRequest()->getParam('id');
		$tableModele = new TModele;

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$data = $tableModele->deleteModele($id);
		}
		else {
			echo $form;
		}
	}
	public function menuAction(){
		$this->_helper->viewRenderer->setResponseSegment('menuMaintenance');
	}
}