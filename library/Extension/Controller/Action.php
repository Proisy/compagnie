<?php

abstract class Extension_Controller_Action extends Extension_Controller_Base
{
	public function init()
	{
		parent::init();
		
		$acl = new Extension_Acl($this->_auth, $this->getRequest());
		
		if($this->_auth->hasIdentity()) {
			$this->_helper->actionStack($this->_auth->getIdentity()->user_role, 'menu', 'default', array());
		}
    }
}