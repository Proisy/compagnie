<?php

class PlanningController extends Zend_Controller_Action
{
	public function init(){}

	public function indexAction(){
		$this->_helper->actionStack('menu', 'planning', 'default', array());
	}
	
	public function menuAction(){
		$this->_helper->viewRenderer->setResponseSegment('menuPlanning');
	}
}