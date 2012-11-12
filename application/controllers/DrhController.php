<?php 
class DrhController extends Extension_Controller_Action
{
 
	public function init(){
		parent::init();
	}
	
	public function indexAction(){
		$this->_helper->actionStack('menu', 'drh', 'default', array());
	}
	
	public function menuAction(){
		$this->_helper->viewRenderer->setResponseSegment('menuDrh');
	}
}