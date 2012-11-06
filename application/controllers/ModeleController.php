<?php

class ModeleController extends Zend_Controller_Action
{
	public function init(){}

	public function indexAction(){
		$tableModele = new TModele;
		$this->view->listeModeles = $tableModele->getAllModeles();
	}

	public function ajouterAction() {
		$form = new Zend_Form;

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$data = $monForm->getValues();

			$tableModele = new TModele;
			$tableModele->addModele($data);
		}
		else {
			echo $form;
		}
	}

	public function modifierAction() {
		$id = $this->getRequest()->getParam('id');
		$tableModele = new TModele;

		$form = new Zend_Form;
		
		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$data = $monForm->getValues();

			$tableModele->editModele($id,$data);
		}
		else {
			$this->view->data = $tableModele->getModele($id);
			echo $form;
		}
	}

	public function supprimerAction() {
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
}