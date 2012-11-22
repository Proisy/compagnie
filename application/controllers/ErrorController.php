<?php 
class ErrorController extends Zend_Controller_Action
{

	public function errorAction()
	{
		$errors = $this->_getParam('error_handler');

		switch ($errors->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

				// 404 error -- controller or action not found
				$this->getResponse()->setHttpResponseCode(404);
				$this->view->message = 'Page not found';
				break;
			default:
				// application error
				$this->getResponse()->setHttpResponseCode(500);
				$this->view->message = 'Application error';
				echo "<script>console.log(".json_encode($errors).")</script>";
				break;
		}

		$this->view->exception = $errors->exception;
		$this->view->request   = $errors->request;
	}

	public function noauthAction() {
		$this->getResponse()->setHttpResponseCode(401);
		$this->view->message = "Vous n'êtes pas autorisé à accéder à cette partie du site";
	}
}