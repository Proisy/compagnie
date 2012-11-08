<?php
 
class VilleController extends Zend_Controller_Action
{
	public function init(){}

	public function indexAction(){
		$tableVille = new TVille;
		$this->view->listeVille = $tableVille->getAllVilles();
	}

	public function viewAction() {
		$id = $this->getRequest()->getParam('id');
		if(!isset($id)){
			$redirector = $this->_helper->getHelper('redirector');
			$redirector->goToUrl('/ville/');
		}
		else {
			$tableAeroportVille = new TAeroportVille;
			var_dump($tableAeroportVille->getLinkedAeroports($id));
		}
	}

	public function ajouterAction() {
		$tablePays = new TPays();
		$listePays = $tablePays->getAllPays();
		
		$form = new Zend_Form;

		$form->setAction('/ville/ajouter/')->setMethod('post');

		$listeInput['ville_nom'] = new Zend_Form_Element_Text('ville_nom');
		$listeInput['id_pays'] = new Zend_Form_Element_Select('id_pays');
		foreach ($listePays as $key => $value) {
			$listeInput['id_pays']->addMultiOption($value['id_pays'], $value['pays_nom'].' - '.$value['pays_continent']);
		}

		$listeInput['ville_nom']->setLabel('Nom')->addValidator(new Zend_Validate_Alpha(array('allowWhiteSpace' => true)));
		$listeInput['id_pays']->setLabel('Pays')->addValidator(new Zend_Validate_Digits());

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();
				$tableVille = new TVille;
				$tableVille->addVille($data);
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
		$tableVille = new TVille;

		$form = new Zend_Form;

		$form->setAction('/ville/modifier/id/'.$id)->setMethod('post');

		$listeInput['ville_nom'] = new Zend_Form_Element_Text('ville_nom');
		$listeInput['id_pays'] = new Zend_Form_Element_Select('id_pays');
		foreach ($listePays as $key => $value) {
			$listeInput['id_pays']->addMultiOption($value['id_pays'], $value['pays_nom'].' - '.$value['pays_continent']);
		}

		$listeInput['ville_nom']->setLabel('Nom')->addValidator(new Zend_Validate_Alpha());
		$listeInput['id_pays']->setLabel('Pays')->addValidator(new Zend_Validate_Digits());

		$dataOld = $tableVille->getVille($id);

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true)->setValue($dataOld[$key]);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();
				$tableVille->editVille($id,$data);
			}
		}
		else {
			$this->view->form = $form;
		}
	}
	
	public function supprimerAction() {
		$id = $this->getRequest()->getParam('id');
		$tableVille = new TVille;

		$form = new Zend_Form;

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$tableVille->deleteVille($id);
		}
		else {
			$this->view->dataVille = $tableVille->getVille($id, array('',''));
		}
	}
}