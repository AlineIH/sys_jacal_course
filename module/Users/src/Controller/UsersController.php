<?php

namespace Users\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Users\Form\UsersForm;
use Users\Model\Users;
use Users\Model\UsersTable;

class UsersController extends AbstractActionController
{

    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(UsersTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {

        return new ViewModel([
            'table' => $this->table->fetchAll()
        ]);
    }

    public function createAction()
    {
        $form = new UsersForm();
        $form->get('submit')->setValue('Nuevo');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $user = new Users();
        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $user->exchangeArray($form->getData());
        $this->table->saveUsers($user);
        return $this->redirect()->toRoute('users');
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute(null, ['action' => 'create']);
        }
        $user = $this->table->getUsers($id);

        $form = new UsersForm();
        $form->bind($user);
        $form->get('submit')->setAttribute('value', 'Editar');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }

        try {
            $this->table->saveUsers($user);
        } catch (Exception $e) {
            \error_log("error updating", $e->getMessage());
        }

        return $this->redirect()->toRoute(null, ['action' => 'index']);
    }


}