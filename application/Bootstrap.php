<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap{
	
	protected function _initErrorHandler() {
		// Désactive le plugin errorHandler
		// $this->bootstrap('frontcontroller')->frontcontroller->throwExceptions(true);
	}

	public function run(){
		parent::run();
	}

	protected function _initConfig() {
		$conf = new Zend_Config_Ini(APPLICATION_PATH.'/config/application.ini', APPLICATION_ENV, array('allowModifications'=>false));
		Zend_Registry::set('config', $conf);
	}

	protected function _initSession(){
		$session = new Zend_Session_Namespace('projetzf', true);
		return $session;
	}

	protected function _initViewData()
	{
		$this->bootstrap('View');
		$view = $this->getResource('View');
		$view->doctype('HTML5');
	}

	protected function _initDb() {
		$db = Zend_Db::factory(Zend_Registry::get('config')->database);
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
		Zend_Registry::set('db', $db);
	}

	protected function _initChargerClasses() {
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('Extension_');
		$autoloader->setFallbackAutoloader(true);
	}

	protected function _initAcl() {
		$acl = new Zend_Config_Ini(APPLICATION_PATH.'/config/acl.ini', APPLICATION_ENV);
		Zend_Registry::set('acl', $acl);

		$this->bootstrap('frontcontroller');
		$front = Zend_Controller_Front::getInstance();
		$aclPlugin = new Extension_Controller_Plugin_Acl(new Extension_Acl());
		$front->registerPlugin($aclPlugin);
	}
}