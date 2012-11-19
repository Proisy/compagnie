<?php
 
class LignesController extends Extension_Controller_Action
{
	public function init(){
		parent::init();
		$this->_helper->actionStack('menu', 'direction', 'default', array());
	}

	public function indexAction(){
	}
}