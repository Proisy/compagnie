<?php

abstract class Extension_Controller_Action extends Zend_Controller_Action
{
	public function init()
	{
		$this->_auth = Zend_Auth::getInstance();
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$this->view->messages = $this->_flashMessenger->getMessages();
		$this->_redirector = $this->_helper->getHelper('Redirector');
		$this->_redirector->setCode(301);

		$this->identity = $this->_auth->getIdentity();
		if(!isset($this->identity)) {
			if($this->getRequest()->getControllerName()!='index') {
				$this->_redirector->goToUrl('/');
			}
		}
    }
}