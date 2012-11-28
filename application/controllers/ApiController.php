<?php

class ApiController extends Extension_Controller_Action
{
	public function init(){
		parent::init();
		$this->_helper->layout->disableLayout();
		header('Content-type: application/json');
		$this->fonction = $this->getRequest()->getParam('fonction');
		$this->listeOperator = array("!=",">=","<=","=",">","<");
	}

	public function indexAction(){
		$obj = null;
		$obj->msg = "Rien à foutre ici";
		echo json_encode($obj);
	}

	public function avionAction() {
		$obj = null;
		switch ($this->fonction) {
			case 'get':
				$id = $this->getRequest()->getParam('id');
				$columnsStr = $this->getRequest()->getParam('columns');
				if(isset($columnsStr)){ $columns = explode(' ',$columnsStr); }
				else { $columns = '*'; }
				$tableAvion = new TAvion;
				echo json_encode($tableAvion->getAvion($id,$columns));
				break;

			case 'getAll':
				$tableAvion = new TAvion;
				$columnsStr = $this->getRequest()->getParam('columns');
				$filterStr = $this->getRequest()->getParam('filter');
				$sortStr = $this->getRequest()->getParam('sort');

				$filter = array();
				if(isset($filterStr)){
					$filterStr = explode(' ', $filterStr);
					foreach ($filterStr as $string) {
						foreach ($this->listeOperator as $operator) {
							if(strstr($string,$operator)!=false) {
								$tmpArr = explode($operator, $string);
								$filter[] = array(
									'column' => $tmpArr[0],
									'operator' => $operator,
									'value' => $tmpArr[1]
								);
								break;
							}
						}
					}
				}

				if(isset($columnsStr)){ $columns = explode(' ',$columnsStr); }
				else { $columns = '*'; }

				if(!empty($filter)){
					echo json_encode($tableAvion->getAvionsBy($filter, $columns));
				}
				else {
					echo json_encode($tableAvion->getAllAvions($columns));
				}
				break;

			case 'ajouter':
				if($this->getRequest()->isPost()) {
					$post = $this->getRequest()->getPost();

					$form = new Zend_Form;
					$listeInput['avion_immatriculation'] = new Zend_Form_Element_Text('avion_immatriculation');
					$listeInput['id_modele'] = new Zend_Form_Element_Text('id_modele');
					$listeInput['avion_heure_vol_total'] = new Zend_Form_Element_Text('avion_heure_vol_total');
					$listeInput['avion_heure_vol_revision'] = new Zend_Form_Element_Text('avion_heure_vol_revision');
					$listeInput['avion_immatriculation']->addValidator(new Zend_Validate_Alnum());
					$listeInput['id_modele']->addValidator(new Zend_Validate_Digits());
					$listeInput['avion_heure_vol_total']->addValidator(new Zend_Validate_Digits());
					$listeInput['avion_heure_vol_revision']->addValidator(new Zend_Validate_Digits());
					foreach ($listeInput as $key=>$value) {
						$value->setRequired(true);
						$form->addElement($value);
					}

					if($form->isValid($post)) {
						$tableAvion = new TAvion;
						if($tableAvion->addAvion($post)) {
							$obj->msg = "Avion ajouté";
							$obj->status = "ok";
							echo json_encode($obj);
						}
						else {
							$obj->msg = "Avion non ajouté";
							$obj->status = "error";
							echo json_encode($obj);
						}
					}
					else {
						$obj->msg = "Erreur: certaines données ne sont pas au bon format";
						$obj->status = "error";
						echo json_encode($obj);
					}

				}
				else {
					$obj->msg = "Erreur: aucune données";
					$obj->status = "error";
					echo json_encode($obj);
				}

			case 'modifier':
				if($this->getRequest()->isPost()) {
					$id = $this->getRequest()->getParam('id');
					$post = $this->getRequest()->getPost();

					$form = new Zend_Form;
					$listeInput['id_modele'] = new Zend_Form_Element_Text('id_modele');
					$listeInput['avion_heure_vol_total'] = new Zend_Form_Element_Text('avion_heure_vol_total');
					$listeInput['avion_heure_vol_revision'] = new Zend_Form_Element_Text('avion_heure_vol_revision');
					$listeInput['id_modele']->addValidator(new Zend_Validate_Digits());
					$listeInput['avion_heure_vol_total']->addValidator(new Zend_Validate_Digits());
					$listeInput['avion_heure_vol_revision']->addValidator(new Zend_Validate_Digits());
					foreach ($listeInput as $key=>$value) {
						$value->setRequired(true);
						$form->addElement($value);
					}

					if($form->isValid($post)) {
						$tableAvion = new TAvion;
						if($tableAvion->editAvion($id, $post)) {
							$obj->msg = "Avion modifié";
							$obj->status = "ok";
							echo json_encode($obj);
						}
						else {
							$obj->msg = "Avion non modifié";
							$obj->status = "error";
							// var_dump($form->getErrors());
							// exit();
							echo json_encode($obj);
						}
					}
					else {
						$obj->msg = "Erreur: certaines données ne sont pas au bon format";
						$obj->status = "error";
						echo json_encode($obj);
					}

				}
				else {
					$obj->msg = "Erreur: aucune données";
					$obj->status = "error";
					echo json_encode($obj);
				}

			default:
				$obj->msg = "Liste des fonctions disponibles";
				$obj->liste = array('get','getAll','ajouter');
				echo json_encode($obj);
				break;
		}
	}
}