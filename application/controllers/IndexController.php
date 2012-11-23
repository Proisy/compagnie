<?php 
class IndexController extends Extension_Controller_Action
{
	public function init()
	{
		parent::init();
	}

	public function indexAction(){

		if($this->_auth->hasIdentity()) {
			$this->_redirector->goToUrl('/'.$this->_auth->getIdentity()->user_role.'/');
		}
		else {
			$this->_helper->layout->setLayout('layout-index');

			$form = new Zend_Form;

			$loginInput = new Zend_Form_Element_Text('login');
			$loginInput->setLabel('Identifiant')
					->setAttrib('required','required');
			$passwordInput = new Zend_Form_Element_Password('password');
			$passwordInput->setLabel('Mot de passe')
					->setAttrib('required','required');

			$submit = new Zend_Form_Element_Submit('Connect');

			$form->addElement($loginInput);
			$form->addElement($passwordInput);
			$form->addElement($submit);

			if($this->getRequest()->isPost()) {
				$post = $this->getRequest()->getPost();
				if($form->isValid($post)) {
					$data = $form->getValues();
					$dbAuthAdapter = new Zend_Auth_Adapter_DbTable(Zend_Registry::get('db'), 'user','user_login','user_password','MD5(?)');
					$dbAuthAdapter->setIdentity($data['login']);
					$dbAuthAdapter->setCredential($data['password']);
					$res = $this->_auth->authenticate($dbAuthAdapter);
					if($res->isValid()) {
						$this->_auth->getStorage()->write($dbAuthAdapter->getResultRowObject(array('user_login','user_role'),null));
						$this->_flashMessenger->addMessage('Vous vous êtes connecté avec succès');
						$this->_redirector->goToUrl('/'.$this->_auth->getIdentity()->user_role.'/');
					}
					else {
						$this->_flashMessenger->addMessage('Mauvais identifiant et/ou mot de passe');
						$this->view->form = $form;
					}
				}
				else {
					$this->_flashMessenger->addMessage('Mauvais identifiant et/ou mot de passe');
					$this->view->form = $form;
				}
			}
			else {
				$this->view->form = $form;
			}
		}
	}

	public function logoutAction() {
		$this->_auth->clearIdentity();
		$this->_flashMessenger->addMessage('Vous êtes déconnecté');
		$this->_redirector->goToUrl('/');
	}
}