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
		$this->view->listeVols = $tableVol->getSomeVols($page,15);
		$this->view->nbVols = (($tableVol->countVols())/15);
	}

	public function viewAction() {
		$id = $this->getRequest()->getParam('id');
		if(!isset($id)){
			$redirector = $this->_helper->getHelper('redirector');
			$redirector->goToUrl('/vol/');
		}
		else {
			$tableVol = new TVol;
			$this->view->vol = $tableVol->getVol($id);
		}
	}

	public function ajouterAction() {
		$form = new Zend_Form;
		$tableVol = new TVol;
		$tableUser = new TUser;
		$tableLigne = new TLigne;
		$tableAeroport = new TAeroport;
		$tableAvion = new TAvion;
		$pilote= $tableUser->getPilote();
		$modele = $tableAvion->getAvMod();
		$destination = $tableLigne->getAllLignes();
		$heure = array();
		$minute = array();
		for($i=0; $i<24; $i++){
			array_push($heure, $i);
		}
		for($i=0; $i<60; $i++){
			array_push($minute, $i);
		}

		$form->setAction('/vol/ajouter/')->setMethod('post')->setAttrib('class', 'volAjouter');

			$listeInput['id_ligne'] = new Zend_Form_Element_Select('id_ligne');
			$listeInput['avion_immatriculation'] = new Zend_Form_Element_Select('avion_immatriculation');
			$listeInput['id_pilote'] = new Zend_Form_Element_Select('id_pilote');
			$listeInput['id_copilote'] = new Zend_Form_Element_Select('id_copilote');
			$listeInput['vol_information'] = new Zend_Form_Element_Text('vol_information');
			$listeInput['vol_date'] = new Zend_Form_Element_Text('vol_date');
			$listeInput['heure_depart'] = new Zend_Form_Element_Select('heure_depart');
			$listeInput['minute_depart'] = new Zend_Form_Element_Select('minute_depart');
			$listeInput['heure_arrivee'] = new Zend_Form_Element_Select('heure_arrivee');
			$listeInput['minute_arrivee'] = new Zend_Form_Element_Select('minute_arrivee');

			$listeInput['id_ligne']->setLabel('Destination');
			foreach ($destination as $key => $value) {
				$nomD = $tableAeroport->getAeroport($value['id_aeroport_depart']);
				$nomA = $tableAeroport->getAeroport($value['id_aeroport_arrivee']);
				$listeInput['id_ligne']->addMultiOptions(array($value['id_ligne'] => $nomD['aeroport_nom'].' - '.$nomA['aeroport_nom']));
			}
			$listeInput['avion_immatriculation']->setLabel('Avion');
			foreach ($modele as $key => $value) {
				$listeInput['avion_immatriculation']->addMultiOptions(array($value['id_modele'] => $value['modele_marque'].' '.$value['modele_reference'].' - '.$value['avion_immatriculation']));
			}
			$listeInput['id_pilote']->setLabel('nom du pilote');
			$listeInput['id_copilote']->setLabel('nom du copilote');
			
			foreach ($pilote as $key => $value) {
				$listeInput['id_pilote']->addMultiOptions(array($value['id_pilote'] => $value['user_nom'].' '.$value['user_prenom']));    
	    		$listeInput['id_copilote']->addMultiOptions(array($value['id_pilote'] => $value['user_nom'].' '.$value['user_prenom']));
	    	}

			$listeInput['vol_information']->setLabel('information du vol');
			$listeInput['vol_date']->setLabel('date du vol')
								   ->setAttrib('id','datepicker');
			$listeInput['heure_depart']->setLabel('Heure de départ (heure/minute)')
									   ->addMultiOptions($heure);
			$listeInput['minute_depart']->addMultiOptions($minute)
										->removeDecorator('Label');
			$listeInput['heure_arrivee']->setLabel('Heure d\'arrivee (heure/minute)')
										->addMultiOptions($heure);
			$listeInput['minute_arrivee']->removeDecorator('Label')
										 ->addMultiOptions($minute);
			$dateDepart = new Zend_Date();
			$dateArrivee = new Zend_Date();
			// Affecter une nouvelle date
			$dateDepart->set(''.$listeInput['heure_depart'].':'.$listeInput['minute_depart'].':00',Zend_Date::TIMES);
			$dateArrivee->set(''.$listeInput['heure_arrivee'].':'.$listeInput['minute_arrivee'].':00',Zend_Date::TIMES);
			unset($listeInput['heure_depart']);
			unset($listeInput['minute_depart']);
			unset($listeInput['heure_arrivee']);
			unset($listeInput['minute_arrivee']);
			$listeInput['id_aeroport_depart'] = $dateDepart;
			//Zend_Debug::dump($listeInput['id_aeroport_depart']);exit();
			$listeInput['id_aeroport_arrivee'] = $dateArrivee;
			foreach ($listeInput as $key=>$value) {
				$value->setRequired(true);
				$form->addElement($value);
			}

		$form->addElement(new Zend_Form_Element_Submit('Valider'));

		if($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)) {
				$data = $form->getValues();
				//Modification de l'heure.tableVol
				$unlink->addVol($data);
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
}