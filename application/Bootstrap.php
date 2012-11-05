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

	protected function _initDb() {
		$db = Zend_Db::factory(Zend_Registry::get('config')->database);
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
		Zend_Registry::set('db', $db);
	}

	protected function _initChargerClasses() {
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('Festival_');
		$autoloader->setFallbackAutoloader(true);
	}
}