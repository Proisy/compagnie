<?php
 
class AvionController extends Zend_Controller_Action
{
	public function init(){}

	public function indexAction(){
		$tableAvion = new TAvion;
		$this->view->listeAvions = $tableAvion->getAllAvions();
	}

	public function ajouterAction() {
		$form = new Zend_Form;

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$data = $monForm->getValues();

			$tableAvion = new TAvion;
			$tableAvion->addAvion($data);
		}
		else {
			$tableModele = new TModele;
			$listeModeles = $tableModele->getAllModeles(array('id_modele','modele_marque','modele_reference'));
			
			echo $form;
		}
	}
	
	public function modifierAction() {
		$id = $this->getRequest()->getParam('id');
		$tableAvion = new TAvion;

		$form = new Zend_Form;

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$data = $monForm->getValues();

			$tableAvion->editAvion($id,$data);
		}
		else {
			$tableModele = new TModele;
			$listeModeles = $tableModele->getAllModeles(array('id_modele','modele_marque','modele_reference'));
			
			$data = $tableAvion->getAvion($id);
			echo $form;
		}
	}
	
	public function supprimerAction() {
		$id = $this->getRequest()->getParam('id');
		$tableAvion = new TAvion;

		$form = new Zend_Form;

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$tableAvion->deleteAvion($id);
		}
		else {
			$this->view->dataAvion = $tableAvion->getAvion($id, array('avion_immatriculation','id_modele'));
			$tableModele = new TModele;
			$this->view->dataAvion = array_merge($this->view->dataAvion,
				$tableModele->getModele($this->view->dataAvion['id_modele'], array('modele_marque','modele_reference')));
			echo $form;
		}
	}
}