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

			default:
				$obj->msg = "Liste des fonctions disponibles";
				$obj->liste = array('get','getAll');
				echo json_encode($obj);
				break;
		}
	}
}