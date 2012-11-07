<?php
 
class PaysController extends Zend_Controller_Action
{
	public function init(){}

	public function indexAction(){
		$tablePays = new TPays;
		$this->view->listePays = $tablePays->getAllPays();
	}

	public function ajouterAction() {
		$form = new Zend_Form;

		$form->setAction('/pays/ajouter/')->setMethod('post');

		$listeInput['pays_nom'] = new Zend_Form_Element_Text('pays_nom');
		$listeInput['pays_continent'] = new Zend_Form_Element_Text('pays_continent');

		$listeInput['pays_nom']->setLabel('Nom')->addValidator(new Zend_Validate_Alpha());
		$listeInput['pays_continent']->setLabel('Continent')->addValidator(new Zend_Validate_Alpha());

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();
				$tablePays = new TPays;
				$tablePays->addPays($data);
			}
		}
		else {
			$this->view->form = $form;
		}
	}
	
	public function modifierAction() {
		$id = $this->getRequest()->getParam('id');
		$tablePays = new TPays;

		$form = new Zend_Form;

		$form->setAction('/pays/modifier/')->setMethod('post');

		$listeInput['pays_nom'] = new Zend_Form_Element_Text('pays_nom');
		$listeInput['pays_continent'] = new Zend_Form_Element_Text('pays_continent');

		$listeInput['pays_nom']->setLabel('Nom')->addValidator(new Zend_Validate_Alpha());
		$listeInput['pays_continent']->setLabel('Continent')->addValidator(new Zend_Validate_Alpha());

		$dataOld = $tablePays->getPays($id);

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true)->setValue($dataOld[$key]);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();
				$tablePays->editPays($id,$data);
			}
		}
		else {
			$this->view->form = $form;
		}
	}
	
	public function supprimerAction() {
		$id = $this->getRequest()->getParam('id');
		$tablePays = new TPays;

		$form = new Zend_Form;

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$tablePays->deletePays($id);
		}
		else {
			$this->view->dataPays = $tablePays->getPays($id, array('pays_nom','pays_continent'));
		}
	}
}