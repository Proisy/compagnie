<?php

class PlanningController extends Extension_Controller_Action
{
	public function init(){
		parent::init();
	}

	public function indexAction(){
		$this->_helper->actionStack('menu', 'planning', 'default', array());
	}
}