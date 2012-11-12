<?php

class UserController extends Extension_Controller_Action
{
	public function init(){
		parent::init();
	}

	public function indexAction(){
		$this->_helper->actionStack('menu', 'maintenance', 'default', array());
		$tableUser = new TUser;
		$this->view->listeUsers = $tableUser->getAllUsers();
	}

	public function viewAction() {
		$id = $this->getRequest()->getParam('id');
		if(!isset($id)){
			$redirector = $this->_helper->getHelper('redirector');
			$redirector->goToUrl('/avion/');
		}
		else {
			
		}
	}

	public function ajouterAction() {
		$form = new Zend_Form;

		$form->setAction('/user/ajouter/')->setMethod('post');

		$listeInput['user_nom'] = new Zend_Form_Element_Text('user_nom');
		$listeInput['user_prenom'] = new Zend_Form_Element_Text('user_prenom');
		$listeInput['user_adresse'] = new Zend_Form_Element_Textarea('user_adresse');
		$listeInput['user_telephone'] = new Zend_Form_Element_Text('user_telephone');
		
		$listeInput['user_nom']->setLabel('Nom de famille')
									->addValidator(new Zend_Validate_Alpha(array('allowWhiteSpace' => true)));
		$listeInput['user_prenom']->setLabel('Prénom')
									->addValidator(new Zend_Validate_Alpha(array('allowWhiteSpace' => true)));
		$listeInput['user_adresse']->setLabel('Adresse')
									->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace'=>true)));
		$listeInput['user_telephone']->setLabel('Numéro de téléphone')
									->addValidator(new Zend_Validate_Alnum())
									->addValidator(new Zend_Validate_Regex(array('pattern'=>'/^(01|02|03|04|05|06|08)[0-9]{8}/')));

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$data = $form->getValues();

			$tableUser = new TUser;
			$tableUser->addUser($data);
		}
		else {
			$this->view->form = $form;
		}
	}

	public function modifierAction() {
		$id = $this->getRequest()->getParam('id');

		$tableUser = new TUser;

		$form = new Zend_Form;

		$form->setAction('/user/modifier/id/'.$id)->setMethod('post');

		$listeInput['user_nom'] = new Zend_Form_Element_Text('user_nom');
		$listeInput['user_prenom'] = new Zend_Form_Element_Text('user_prenom');
		$listeInput['user_adresse'] = new Zend_Form_Element_Textarea('user_adresse');
		$listeInput['user_telephone'] = new Zend_Form_Element_Text('user_telephone');
		
		$listeInput['user_nom']->setLabel('Nom de famille')
									->addValidator(new Zend_Validate_Alpha(array('allowWhiteSpace' => true)));
		$listeInput['user_prenom']->setLabel('Prénom')
									->addValidator(new Zend_Validate_Alpha(array('allowWhiteSpace' => true)));
		$listeInput['user_adresse']->setLabel('Adresse')
									->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace'=>true)));
		$listeInput['user_telephone']->setLabel('Numéro de téléphone')
									->addValidator(new Zend_Validate_Alnum())
									->addValidator(new Zend_Validate_Regex(array('pattern'=>'/^(01|02|03|04|05|06|08)[0-9]{8}/')));

		$dataOld = $tableUser->getUser($id);

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true)->setValue($dataOld[$key]);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));
		
		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$data = $form->getValues();

			$tableUser->edituser($id,$data);
		}
		else {
			$this->view->form = $form;
		}
	}

	public function supprimerAction() {
		$id = $this->getRequest()->getParam('id');
		$tableUser = new TUser;

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$data = $tableUser->deleteUser($id);
		}
		else {
			echo $form;
		}
	}
}