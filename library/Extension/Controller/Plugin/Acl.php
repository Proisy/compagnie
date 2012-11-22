<?php
 
class Extension_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

	/**
	 *
	 * @var Zend_Auth
	 */
	protected $_auth;

	protected $_acl;
	protected $_action;
	protected $_controller;
	protected $_currentUserRole;

	public function __construct(Zend_Acl $acl, array $options = array()) {
		$this->_auth = Zend_Auth::getInstance();
		$this->_acl = $acl;
	}

	public function preDispatch(Zend_Controller_Request_Abstract $request) {

		$this->_init($request);

		// if the current user role is not allowed to do something
		if (!$this->_acl->isAllowed($this->_currentUserRole, $this->_controller, $this->_action)) {

			if ('anonyme' == $this->_currentUserRole) {
				$request->setControllerName('index');
				$request->setActionName('index');
			}
			else {
				$request->setControllerName('error');
				$request->setActionName('noauth');
			}
		}
	}

	protected function _init($request) {
		$this->_action = $request->getActionName();
		$this->_controller = $request->getControllerName();
		$this->_currentUserRole = $this->_getCurrentUserRole();
	}

	protected function _getCurrentUserRole() {  

		if ($this->_auth->hasIdentity()) {
			$authData = $this->_auth->getIdentity();
			$role = isset($authData->user_role)?strtolower($authData->user_role): 'anonyme';
		} else {
			$role = 'anonyme';
		}

		return $role;
	}
}