<?php

declare(strict_types=1);

namespace HelloWorld\Controller;

use HelloWorld\Service\GreetingService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

use HelloWorld\Form\ContactForm;

class IndexController extends AbstractActionController
{
  private $greetingService;

  public function __construct(GreetingService $greetingService)
  {
    $this->greetingService = $greetingService;
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
}
