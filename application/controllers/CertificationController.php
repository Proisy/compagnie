<?php
 
class CertificationController extends Zend_Controller_Action
{
	public function init(){}

	public function indexAction(){
		$tableCertification = new TCertification;
		$this->view->listeCertifications = $tableCertification->getAllCertifications();
	}

	public function viewAction() {
		$id = $this->getRequest()->getParam('id');
		if(!isset($id)){
			$redirector = $this->_helper->getHelper('redirector');
			$redirector->goToUrl('/certification/');
		}
		else {
			
		}
	}

	public function ajouterAction() {
		$form = new Zend_Form;

		$form->setAction('/certification/ajouter/')->setMethod('post');

		$listeInput['certification_nom'] = new Zend_Form_Element_Text('certification_nom');
		$listeInput['certification_validite'] = new Zend_Form_Element_Text('certification_validite');

		$listeInput['certification_nom']->setLabel('Nom')
						->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
		$listeInput['certification_validite']->setLabel('Durée de validité (en mois)')->addValidator(new Zend_Validate_Digits());

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();
				$tableCertification = new TCertification;
				$tableCertification->addCertification($data);
			}
		}
		else {
			$this->view->form = $form;
		}
	}

	public function modifierAction() {
		$id = $this->getRequest()->getParam('id');
		$tableCertification = new TCertification;

		$form = new Zend_Form;

		$form->setAction('/certification/modifier/id/'.$id)->setMethod('post');

		$listeInput['certification_nom'] = new Zend_Form_Element_Text('certification_nom');
		$listeInput['certification_validite'] = new Zend_Form_Element_Text('certification_validite');

		$listeInput['certification_nom']->setLabel('Nom')
						->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
		$listeInput['certification_validite']->setLabel('Durée de validité (en mois)')->addValidator(new Zend_Validate_Digits());

		$dataOld = $tableCertification->getCertification($id);

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true)->setValue($dataOld[$key]);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();
				$tableCertification->editCertification($id,$data);
			}
		}
		else {
			$this->view->form = $form;
		}
	}
	
	public function supprimerAction() {
		$id = $this->getRequest()->getParam('id');
		$tableCertification = new TCertification;

		$form = new Zend_Form;

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$tableCertification->deleteCertification($id);
		}
		else {
			$this->view->dataCertification = $tableCertification->getCertification($id);
		}
	}

	public function linkmodeleAction() {
		$id = $this->getRequest()->getParam('id');

		$tableModele = new TModele;
		$listeModeles = $tableModele->getAllModeles(array('id_modele', 'modele_marque', 'modele_reference'));

		$form = new Zend_Form;

		$listeInput['id_modele'] = new Zend_Form_Element_Select('id_modele');

		foreach ($listeModeles as $key => $value) {
			$listeInput['id_modele']->addMultiOption($value['id_modele'], $value['modele_marque'].' '.$value['modele_reference']);
		}

		$listeInput['id_modele']->setLabel('Modèle')->addValidator(new Zend_Validate_Digits());

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$tableCertificationModele = new TCertificationModele;
				$dataLink = array('id_certification'=>$id, 'id_modele'=>$post['id_modele']);
				$tableCertificationModele->addLink($dataLink);
			}
		}
		else {
			$this->view->form = $form;
		}
	}

	public function unlinkmodeleAction() {
		
	}
}