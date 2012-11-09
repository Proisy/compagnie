<?php 
class DrhController extends Zend_Controller_Action
{
 
	public function init(){}
	
	public function indexAction(){
		$this->_helper->actionStack('menu', 'drh', 'default', array());
	}
	
	public function menuAction(){
		$this->_helper->viewRenderer->setResponseSegment('menuDrh');
	}
}