<?php 
class IndexController extends Zend_Controller_Action
{
	protected $_redirector = null;
	 
	public function init()
	{
		$this->_redirector = $this->_helper->getHelper('Redirector');
	}
		
	public function webglAction(){
		
	}
		
	public function indexAction(){
		$this->_helper->layout->setLayout('layout-index');
		$this->_helper->actionStack('webgl', 'index');
		$identifiantSaisi = 'GG153P';
		$passwordSaisi = 'fb22e9473b9d40563b75c3a6783d228a';
		//connection à la base de données
		$db = Zend_Registry::get('db');
		// Instancation de Zend_Auth
		$auth = Zend_Auth::getInstance();
		//charger et parametrer l'adaptateur
		$dbAdapter = new Zend_Auth_Adapter_DbTable($db, 'Personnels', 'identifiant', 'password', 'MD5(?)');
		//cahrger l'identifiant et le mdp a tester
		$dbAdapter->setIdentity($identifiantSaisi);
		$dbAdapter->setCredential($passwordSaisi);
		//On test l'authentification
		$resultat = $auth->authenticate($dbAdapter);
		if($resultat->isValid()){
			echo "utilisateur ok";
		} else echo "erreur d'auth";
	}
		
	public function loginAction(){
	}
}