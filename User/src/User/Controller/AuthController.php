<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Form;

class AuthController extends AbstractActionController
{

    public function loginAction()
    {
        $data = $this->getRequest()->getPost();
        $form = new Form\LoginForm(null, $this->getServiceLocator());
        if ($this->getRequest()->isPost()) {
            // If you used another name for the authentication service, change it here
            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

            $adapter = $authService->getAdapter();
            $adapter->setIdentityValue($data['email']);
            $adapter->setCredentialValue($data['password']);
            $authResult = $authService->authenticate();

            if ($authResult->isValid()) {
                $this->flashMessenger()->addSuccessMessage('You\'re successfully logged in');
                return $this->redirect()->toRoute('home');
            }
        }

        return new ViewModel(array('form' => $form));
    }

    public function logoutAction()
    {
        if ($this->identity()) {
            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            $authService->clearIdentity();
        }

        return $this->redirect()->toRoute('user/default', ['controller' => 'auth', 'action' => 'login']);
    }
}
