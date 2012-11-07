<?php
 
class AeroportController extends Zend_Controller_Action
{
	public function init(){
		// $this->view->setEscape('utf8_encode');
	}

	public function indexAction(){
		$tableAeroport = new TAeroport;
		$this->view->listeAeroport = $tableAeroport->getAllAeroports();
	}

	public function ajouterAction() {
		$form = new Zend_Form;

		$form->setAction('/aeroport/ajouter/')->setMethod('post');

		$listeInput['aeroport_trigramme'] = new Zend_Form_Element_Text('aeroport_trigramme');
		$listeInput['aeroport_nom'] = new Zend_Form_Element_Text('aeroport_nom');
		$listeInput['aeroport_terminaux'] = new Zend_Form_Element_Text('aeroport_terminaux');
		$listeInput['aeroport_longueur_piste'] = new Zend_Form_Element_Text('aeroport_longueur_piste');

		$listeInput['aeroport_trigramme']->setLabel('Trigramme')
						->addValidator(new Zend_Validate_Alpha())
						->addValidator(new Zend_Validate_StringLength(array('min'=>3,'max'=>3)));
		$listeInput['aeroport_nom']->setLabel('Nom')->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
		$listeInput['aeroport_terminaux']->setLabel('Nombre de terminaux')->addValidator(new Zend_Validate_Digits());
		$listeInput['aeroport_longueur_piste']->setLabel('Longueur maximale de piste (en m)')->addValidator(new Zend_Validate_Digits());

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();
				$tableAeroport = new TAeroport;
				$tableAeroport->addAeroport($data);
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
		$tableAeroport = new TAeroport;

		$form = new Zend_Form;

		$form->setAction('/aeroport/modifier/')->setMethod('post');

		$listeInput['aeroport_trigramme'] = new Zend_Form_Element_Text('aeroport_trigramme');
		$listeInput['aeroport_nom'] = new Zend_Form_Element_Text('aeroport_nom');
		$listeInput['aeroport_terminaux'] = new Zend_Form_Element_Text('aeroport_terminaux');
		$listeInput['aeroport_longueur_piste'] = new Zend_Form_Element_Text('aeroport_longueur_piste');

		$listeInput['aeroport_trigramme']->setLabel('Trigramme')
						->addValidator(new Zend_Validate_Alpha())
						->addValidator(new Zend_Validate_StringLength(array('min'=>3,'max'=>3)));
		$listeInput['aeroport_nom']->setLabel('Nom')->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
		$listeInput['aeroport_terminaux']->setLabel('Nombre de terminaux')->addValidator(new Zend_Validate_Digits());
		$listeInput['aeroport_longueur_piste']->setLabel('Longueur maximale de piste (en m)')->addValidator(new Zend_Validate_Digits());

		$dataOld = $tableAeroport->getAeroport($id);

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true)->setValue($dataOld[$key]);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();
				$tableAeroport->editAeroport($id,$data);
			}
		}
		else {
			$this->view->form = $form;
		}
	}
	
	public function supprimerAction() {
		$id = $this->getRequest()->getParam('id');
		$tableAeroport = new TAeroport;

		$form = new Zend_Form;

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$tableAeroport->deleteAeroport($id);
		}
		else {
			$this->view->dataAeroport = $tableAeroport->getAeroport($id, array('',''));
		}
	}
}