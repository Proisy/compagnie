<?php
 
class AeroportController extends Extension_Controller_Action
{
	public function init(){
		parent::init();
	}

	public function indexAction(){
		$page=$this->getRequest()->getParam('page');
		if(!isset($page)) {
			$page = 1;
		}
		$tableAeroport = new TAeroport;
		$this->view->listeAeroport = $tableAeroport->getSomeAeroports($page,15);
		$this->view->nbAeroport = (($tableAeroport->countAeroport())/15);
	}

	public function viewAction() {
		$id = $this->getRequest()->getParam('id');
		if(!isset($id)){
			$redirector = $this->_helper->getHelper('redirector');
			$redirector->goToUrl('/aeroport/');
		}
		else {
			$tableAeroport = new TAeroport;
			$this->view->aeroport = $tableAeroport->getAeroport($id);
		}
	}

	public function ajouterAction() {
		$form = new Zend_Form;

		$form->setAction('/aeroport/ajouter/')->setMethod('post')->setAttrib('class', 'aeroportAjouter');

		$listeInput['aeroport_trigramme'] = new Zend_Form_Element_Text('aeroport_trigramme');
		$listeInput['aeroport_nom'] = new Zend_Form_Element_Text('aeroport_nom');
		$listeInput['aeroport_terminaux'] = new Zend_Form_Element_Text('aeroport_terminaux');
		$listeInput['aeroport_longueur_piste'] = new Zend_Form_Element_Text('aeroport_longueur_piste');

		$listeInput['aeroport_trigramme']->setLabel('Trigramme')
						->addValidator(new Zend_Validate_Alnum())
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
				$this->_redirector->goToUrl('/aeroport/');
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
		$tableAeroport = new TAeroport;

		$form = new Zend_Form;

		$form->setAction('/aeroport/modifier/id/'.$id)->setMethod('post');

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
				$this->_redirector->goToUrl('/aeroport/');
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
		$tableAeroport = new TAeroport;

		$form = new Zend_Form;

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			$form->isValid($post);
			$tableAeroport->deleteAeroport($id);
			$this->_redirector->goToUrl('/aeroport/');
		}
		else {
			$this->view->dataAeroport = $tableAeroport->getAeroport($id);
		}
	}

	public function linkvilleAction() {
		$id = $this->getRequest()->getParam('id');

		$tableAeroportVille = new TAeroportVille;
		$listeVilles = $tableAeroportVille->getUnlinkedVilles($id);

		$form = new Zend_Form;

		$listeInput['id_ville'] = new Zend_Form_Element_Select('id_ville');

		foreach ($listeVilles as $key => $value) {
			$listeInput['id_ville']->addMultiOption($value['id_ville'], $value['ville_nom'].' - '.$value['pays_nom']);
		}

		$listeInput['id_ville']->setLabel('Ville')->addValidator(new Zend_Validate_Digits());

		foreach ($listeInput as $key=>$value) {
			$value->setRequired(true);
			$form->addElement($value);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$tableAeroportVille = new TAeroportVille;
				$dataLink = array('aeroport_trigramme'=>$id, 'id_ville'=>$post['id_ville']);
				$tableAeroportVille->addLink($dataLink);
			}
		}
		else {
			$this->view->form = $form;
		}
	}

	public function unlinkvilleAction() {
		$id_a = $this->getRequest()->getParam('id_a');
		$id_v = $this->getRequest()->getParam('id_v');

		$tableVille = new TVille;
		$dataVille = $tableVille->getVillePays($id_v);

		$tableAeroport = new TAeroport;
		$dataAeroport = $tableAeroport->getAeroport($id_a,array('aeroport_trigramme','aeroport_nom'));

		$form = new Zend_Form;

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();

			if($form->isValid($post)) {
				$tableAeroportVille = new TAeroportVille;
				$tableAeroportVille->removeLink(array('aeroport_trigramme'=>$id_a, 'id_ville'=>$id_v));
			}
		}
		else {
			$this->view->form = $form;
		}
	}
}