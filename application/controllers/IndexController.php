<?php

class IndexController extends Zend_Controller_Action{
	
	public function indexAction(){
		$this->_helper->actionStack('login', 'index', 'default', array());
    }

	public function loginAction() {
		$this->_helper->viewRenderer->setResponseSegment('login');
	}

	public function init(){
		$this->_helper->actionStack('afficher', 'menu', 'default', array());
	}

	// public function preDispatch(){ }

	// public function postDispatch(){ }
	
}