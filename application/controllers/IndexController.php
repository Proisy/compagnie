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
		$identifiantSaisi = 'JD865P';
		$passwordSaisi = '5c5dd62d44fd9ba931876b73e9f232f2';
		//connection à la base de données
		$db = Zend_Registry::get('db');
		// Instancation de Zend_Auth
		$auth = Zend_Auth::getInstance();
		//charger et parametrer l'adaptateur
		$dbAdapter = new Zend_Auth_Adapter_DbTable($db, 'user', 'user_identifiant', 'user_password', 'MD5(?)');
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