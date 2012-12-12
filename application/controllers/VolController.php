<?php 
class VolController extends Extension_Controller_Action
{
	public function init(){
		parent::init();
	}

	public function indexAction(){ 
		$page=$this->getRequest()->getParam('page');
		if(!isset($page)) {
			$page = 1;
		}
		$tableVol = new TVol;
		$this->view->listeVols = $tableVol->getSomeVolsFK($page,15);
		$this->view->nbVols = ($tableVol->countVols())/15;
	}

	public function viewAction() {
		$id = $this->getRequest()->getParam('id');
		if(!isset($id)){
			$this->_redirector->goToUrl('/vol/');
		}
		else {
			$tableVol = new TVol;
			$this->view->vol = $tableVol->getVol($id);
		}
	}

	public function ajouterAction() {
		$form = new Zend_Form;

		$tableUser = new TUser;
		$tableLigne = new TLigne;
		$tableAvion = new TAvion;

		$listePilotes = $tableUser->getAllPilotes(array('user_login','user_nom','user_prenom'));
		$listeAvions = $tableAvion->getAllAvionsFK(array('avion_immatriculation'));
		$listeLignes = $tableLigne->getAllLignesFK();

		$form->setAction('/vol/ajouter/')->setMethod('post');

		$listeInput['id_ligne'] = new Zend_Form_Element_Select('id_ligne');
		$listeInput['avion_immatriculation'] = new Zend_Form_Element_Select('avion_immatriculation');
		$listeInput['id_pilote'] = new Zend_Form_Element_Select('id_pilote');
		$listeInput['id_copilote'] = new Zend_Form_Element_Select('id_copilote');
		$listeInput['vol_date'] = new Zend_Form_Element_Text('vol_date');
		$listeInput['heure_depart'] = new Zend_Form_Element_Text('heure_depart');
		$listeInput['minute_depart'] = new Zend_Form_Element_Text('minute_depart');
		$listeInput['heure_arrivee'] = new Zend_Form_Element_Text('heure_arrivee');
		$listeInput['minute_arrivee'] = new Zend_Form_Element_Text('minute_arrivee');

		$listeInput['id_ligne']->setLabel('Ligne');

		foreach ($listeLignes as $ligne) {
			$listeInput['id_ligne']->addMultiOptions(array(
				$ligne['id_ligne'] => $ligne['aeroport_depart'].' - '.$ligne['aeroport_arrivee'])
			);
		}

		$listeInput['avion_immatriculation']->setLabel('Avion');
		foreach ($listeAvions as $avion) {
			$listeInput['avion_immatriculation']->addMultiOptions(array(
				$avion['avion_immatriculation'] => $avion['modele_marque'].' '.$avion['modele_reference'].' - '.$avion['avion_immatriculation']
			));
		}

		$listeInput['id_pilote']->setLabel('Pilote');
		$listeInput['id_copilote']->setLabel('Copilote');
		
		foreach ($listePilotes as $pilote) {
			$listeInput['id_pilote']->addMultiOptions(array(
				$pilote['user_login'] => $pilote['user_nom'].' '.$pilote['user_prenom']
			));
			$listeInput['id_copilote']->addMultiOptions(array(
				$pilote['user_login'] => $pilote['user_nom'].' '.$pilote['user_prenom']
			));
		}

		$listeInput['vol_date']->setLabel('date du vol')
							->setAttrib('id','datepicker')
							->setAttrib('size','8');
		$listeInput['heure_depart']->setLabel('Heure de départ (heure/minute)')
								->addValidator(new Zend_Validate_Between(array('min'=>0,'max'=>24)))
								->setAttrib('size','2');
		$listeInput['minute_depart']->removeDecorator('Label')
									->addValidator(new Zend_Validate_Between(array('min'=>0,'max'=>59)))
									->setAttrib('size','2');
		$listeInput['heure_arrivee']->setLabel('Heure d\'arrivee (heure/minute)')
									->addValidator(new Zend_Validate_Between(array('min'=>0,'max'=>24)))
									->setAttrib('size','2');
		$listeInput['minute_arrivee']->removeDecorator('Label')
									->addValidator(new Zend_Validate_Between(array('min'=>0,'max'=>59)))
									->setAttrib('size','2');

		foreach ($listeInput as $element) {
			$element->setRequired(true);
			$form->addElement($element);
		}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$tableVol = new TVol;
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();

				$tmp = explode('/', $data['vol_date']);
				$data['vol_date'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

				$data['vol_depart_prevu'] = $data['vol_date'].' '.$data['heure_depart'].':'.$data['minute_depart'].':00';
				$data['vol_arrivee_prevue'] = $data['vol_date'].' '.$data['heure_arrivee'].':'.$data['minute_arrivee'].':00';
				$data['vol_arrivee_effective'] = $data['vol_arrivee_prevue'];

				unset($data['heure_depart']);
				unset($data['minute_depart']);
				unset($data['heure_arrivee']);
				unset($data['minute_arrivee']);
				unset($data['vol_date']);

				$tableVol->addVol($data);
				$this->_redirector->goToUrl('/vol');
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
}