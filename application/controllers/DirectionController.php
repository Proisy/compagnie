<?php

class DirectionController extends Extension_Controller_Action
{
	public function init(){
		parent::init();
	}

	public function indexAction(){
		$this->_helper->actionStack('menu', 'direction', 'default', array());
	}
	
	public function menuAction(){
		$this->_helper->viewRenderer->setResponseSegment('menuDirection');
	}
}