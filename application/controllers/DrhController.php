<?php 
class IndexController extends Zend_Controller_Action
{
 
	public function init(){}
	
	public function indexAction(){
		echo 'plop';
		$db = Zend_Registry::get('db');
		$tablePersonnels = new TPersonnel;
		$requetePersonnels = $tablePersonnels->select()
											 ->from((array('tabPerso' => 'TPersonnel')),array('tabPerso.identifiant','tabPerso.password'));
		$loginPersonnels = $tablePersonnels->fetchAll($requetePersonnels);
		
		Zend_Debug::dump($loginPersonnels);
	}
}