<?php

declare(strict_types=1);

namespace HelloWorld\Controller;

use HelloWorld\Model\User;
use HelloWorld\Form\UserForm;
use HelloWorld\Model\UserTable;
use HelloWorld\Form\ContactForm;

use Laminas\View\Model\ViewModel;
use HelloWorld\Service\GreetingService;
use Laminas\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
  private $greetingService;

  private $userTable;

  public function __construct(GreetingService $greetingService, UserTable $userTable)
  {
    $this->greetingService = $greetingService;
    $this->userTable = $userTable;
  }
  public function indexAction()
  {
    return new ViewModel();
  }

  public function greetAction()
  {
    // Step 1 : Understand routing concept deeper
    // $name = $this->params()->fromRoute('name', 'Guest');
    // return new ViewModel(['name' => $name]);

    // Step 2 : Dependency Injection dan Service Manager
    $name = $this->params()->fromRoute('name', 'Guest');
    $greeting = $this->greetingService->getGreeting($name);
    return new ViewModel(['greeting' => $greeting]);
  }

  // Step 3 : Form Handling
  public function contactAction()
  {
    $form = new ContactForm();
    $request = $this->getRequest();

    if ($request->isPost()) {
      $form->setData($request->getPost());

      if ($form->isValid()) {
        $data = $form->getData();
        return new ViewModel([
          'form' => $form,
          'message' => 'Form berhasil dikirim!',
        ]);
      }
    }

    return new ViewModel(['form' => $form]);
  }

  public function listAction()
  {
    return new ViewModel([
      'users' => $this->userTable->fetchAll(),
    ]);
  }

  public function addAction()
  {
    $form = new UserForm();
    $form->get('submit')->setValue('Add');

    $request = $this->getRequest();

    if ($request->isPost()) {
      $user = new User();
      $form->setData($request->getPost());

      if ($form->isValid()) {
        $user->exchangeArray($form->getData());
        $this->userTable->saveUser($user);
        return $this->redirect()->toRoute('user-list');
      }
    }

    return ['form' => $form];
  }

}
