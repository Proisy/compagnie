<?php
 
class AvionController extends Extension_Controller_Action
{
	public function init(){
		parent::init();
	}

	public function indexAction(){
		$this->_helper->actionStack('menu', 'maintenance', 'default', array());
		$tableAvion = new TAvion;
		$this->view->listeAvions = $tableAvion->getAllAvions();
		$tableModele = new TModele;
		foreach ($this->view->listeAvions as $key=>$value) {
			$dataModele = $tableModele->getModele($value['id_modele'], array('modele_marque','modele_reference'));
			$this->view->listeAvions[$key] = array_merge($value, $dataModele);
		}
	}

	public function viewAction() {
		$id = $this->getRequest()->getParam('id');
		if(!isset($id)){
			$this->redirector->goToUrl('/avion/');
		}
	}

	public function ajouterAction() {
		$this->_helper->actionStack('menu', 'maintenance', 'default', array());
		$tableModele = new TModele;
		$listeModeles = $tableModele->getAllModeles(array('id_modele','modele_marque','modele_reference'));
		
		$form = new Zend_Form;

		$form->setAction('/avion/ajouter/')->setMethod('post');

		$listeInput['avion_immatriculation'] = new Zend_Form_Element_Text('avion_immatriculation');
		$listeInput['id_modele'] = new Zend_Form_Element_Select('id_modele');
		$listeInput['avion_heure_vol_total'] = new Zend_Form_Element_Text('avion_heure_vol_total');
		$listeInput['avion_heure_vol_revision'] = new Zend_Form_Element_Text('avion_heure_vol_revision');

		$listeInput['avion_immatriculation']->setLabel('Immatriculation')
										->addValidator(new Zend_Validate_Digits());
		$listeInput['id_modele']->setLabel('Modèle')
								->addValidator(new Zend_Validate_Digits());
		foreach ($listeModeles as $key => $value) {
			$listeInput['id_modele']->addMultiOption($value['id_modele'], $value['modele_marque'].' '.$value['modele_reference']);
		}
		$listeInput['avion_heure_vol_total']->setLabel('Heures de vol total de l\'avion')
										->addValidator(new Zend_Validate_Digits());
		$listeInput['avion_heure_vol_revision']->setLabel('Heures de vol depuis la dernière révision')
										->addValidator(new Zend_Validate_Digits());

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();
				$tableAvion = new TAvion;
				$tableAvion->addAvion($data);
				$this->_flashMessenger->addMessages("Avion ajouté");
				$this->_redirector->goToUrl("/avion/");
			}
		}
		else {
			$this->view->form = $form;
		}
	}
	
	public function modifierAction() {
		$this->_helper->actionStack('menu', 'maintenance', 'default', array());
		$id = $this->getRequest()->getParam('id');
		$tableAvion = new TAvion;

		$tableModele = new TModele;
		$listeModeles = $tableModele->getAllModeles(array('id_modele','modele_marque','modele_reference'));
		
		$form = new Zend_Form;

		$form->setAction('/avion/modifier/id/'.$id)->setMethod('post');

		$listeInput['avion_immatriculation'] = new Zend_Form_Element_Text('avion_immatriculation');
		$listeInput['id_modele'] = new Zend_Form_Element_Select('id_modele');
		$listeInput['avion_heure_vol_total'] = new Zend_Form_Element_Text('avion_heure_vol_total');
		$listeInput['avion_heure_vol_revision'] = new Zend_Form_Element_Text('avion_heure_vol_revision');

		$listeInput['avion_immatriculation']->setLabel('Immatriculation')
										->addValidator(new Zend_Validate_Digits());
		$listeInput['id_modele']->setLabel('Modèle')
								->addValidator(new Zend_Validate_Digits());
		foreach ($listeModeles as $key => $value) {
			$listeInput['id_modele']->addMultiOption($value['id_modele'], $value['modele_marque'].' '.$value['modele_reference']);
		}
		$listeInput['avion_heure_vol_total']->setLabel('Heures de vol total de l\'avion')
										->addValidator(new Zend_Validate_Digits());
		$listeInput['avion_heure_vol_revision']->setLabel('Heures de vol depuis la dernière révision')
										->addValidator(new Zend_Validate_Digits());

		$dataOld = $tableAvion->getAvion($id);

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true)->setValue($dataOld[$key]);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();
				$tableAvion->editAvion($id,$data);
				$this->_flashMessenger->addMessages("Avion modifié");
				$this->_redirector->goToUrl("/avion/");
			}
		}
		else {
			$this->view->form = $form;
		}
	}
	
	public function supprimerAction() {
		$this->_helper->actionStack('menu', 'maintenance', 'default', array());
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